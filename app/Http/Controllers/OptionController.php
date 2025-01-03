<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionRequest;
use App\Models\Option;
use App\Models\School;
use App\Services\OptionService;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    protected OptionService $optionService;

    public function __construct(OptionService $optionService)
    {
        $this->optionService = $optionService;
        $this->middleware('auth');
    }

    // Ajoutez les autorisations manuellement dans chaque méthode
    public function index()
    {
        $currentUser = auth()->user();
        $options = $this->optionService->getOptionsList($currentUser, [
            'name' => request('name'),
            'school' => request('school')
        ]);

        return view('options.index', compact('options'));
    }


    public function create()
    {
        $this->authorize('create', Option::class);
        // Si c'est un admin, on ne montre que son zécole
        if (auth()->user()->canManageOwnOptions()) {
            $schools = School::where('id', auth()->user()->school_id)->get();
        } // Si c'est un super admin, on montre toutes les écoles
        else {
            $schools = School::all();
        }
        return view('options.form', compact('schools'));
    }

    public function store(OptionRequest $request)
    {
        $option = $this->optionService->store($request->validated(), auth()->user());
        return redirect()->route('options.index')
            ->with('success', 'Option créée avec succès.');
    }

    public function edit(Option $option)
    {
        $schools = School::all();
        return view('options.form', compact('option', 'schools'));
    }

    public function update(OptionRequest $request, Option $option)
    {
        $this->optionService->update($option, $request->validated());
        return redirect()->route('options.index')
            ->with('success', 'Option mise à jour avec succès.');
    }

    public function destroy(Option $option)
    {
        $this->optionService->delete($option);
        return redirect()->route('options.index')
            ->with('success', 'Option supprimée avec succès.');
    }
}
