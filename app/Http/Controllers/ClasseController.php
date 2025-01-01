<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Option;
use App\Models\School;
use App\Services\ClassService;
use App\Http\Requests\ClassRequest;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    protected $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Classe::class);

        $classes = $this->classService->getClassesList(auth()->user(), [
            'name' => $request->get('name'),
            'school' => $request->get('school')
        ]);

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $this->authorize('create', Classe::class);

        $options = Option::when(auth()->user()->role->name !== 'Super Administrateur', function($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->get();

        // Récupérer les écoles selon le rôle
        $schools = auth()->user()->role->name === 'Super Administrateur'
            ? School::all()
            : School::where('id', auth()->user()->school_id)->get();

        return view('classes.form', compact('options', 'schools'));
    }


    public function store(ClassRequest $request)
    {
        $this->authorize('create', Classe::class);

        $class = $this->classService->store($request->validated(), auth()->user());

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe créée avec succès');
    }

    public function edit(Classe $class)
    {
        $this->authorize('update', $class);

        $options = Option::when(auth()->user()->role->name !== 'Super Administrateur', function($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->get();

        // Récupérer les écoles selon le rôle
        $schools = auth()->user()->role->name === 'Super Administrateur'
            ? School::all()
            : School::where('id', auth()->user()->school_id)->get();

        return view('classes.form', compact('class', 'options', 'schools'));
    }

    public function update(ClassRequest $request, Classe $class)
    {
        $this->authorize('update', $class);

        $this->classService->update($class, $request->validated());

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe mise à jour avec succès');
    }

    public function destroy(Classe $class)
    {
        $this->authorize('delete', $class);

        $this->classService->delete($class);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe supprimée avec succès');
    }
}
