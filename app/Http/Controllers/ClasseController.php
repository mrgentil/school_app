<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRequest;
use App\Models\Classe;
use App\Models\School;
use App\Services\ClassService;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    protected $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
        $this->middleware('auth');
        // Retirez temporairement cette ligne pour déboguer
        // $this->authorizeResource(Classes::class, 'class');
    }

    // Ajoutez les autorisations manuellement dans chaque méthode
    public function index()
    {
        $currentUser = auth()->user();
        $classes = $this->classService->getClassesList($currentUser, [
            'name' => request('name'),
            'school' => request('school')
        ]);

        return view('classes.index', compact('classes'));
    }


    public function create()
    {
        $this->authorize('create', Classe::class);
        // Si c'est un admin, on ne montre que son école
        if (auth()->user()->canManageOwnClasses()) {
            $schools = School::where('id', auth()->user()->school_id)->get();
        } // Si c'est un super admin, on montre toutes les écoles
        else {
            $schools = School::all();
        }
        return view('classes.form', compact('schools'));
    }

    public function store(ClassRequest $request)
    {
        $class = $this->classService->store($request->validated(), auth()->user());
        return redirect()->route('classes.index')
            ->with('success', 'Classe créée avec succès.');
    }

    public function edit(Classe $class)
    {
        $schools = School::all();
        return view('classes.form', compact('class', 'schools'));
    }

    public function update(ClassRequest $request, Classe $class)
    {
        $this->classService->update($class, $request->validated());
        return redirect()->route('classes.index')
            ->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroy(Classe $class)
    {
        $this->classService->delete($class);
        return redirect()->route('classes.index')
            ->with('success', 'Classe supprimée avec succès.');
    }
}
