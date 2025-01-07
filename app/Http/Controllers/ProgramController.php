<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramRequest;
use App\Models\Program;
use App\Services\ProgramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    protected $programService;

    public function __construct(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    public function index(Request $request)
    {
        $programs = $this->programService->getProgramList(auth()->user(), $request->all());
        return view('programmes.index', compact('programs'));
    }

    public function create()
    {
        $schools = auth()->user()->role->name === 'Super Administrateur'
            ? \App\Models\School::all()
            : [];

        return view('programmes.form', compact('schools'));
    }

    public function store(ProgramRequest $request)
    {
        $this->programService->store($request->validated() + ['file' => $request->file('file')], auth()->user());
        return redirect()->route('programmes.index')->with('success', 'Programme créé avec succès.');
    }


    public function edit(Program $program)
    {
        $this->authorize('update', $program);

        $schools = auth()->user()->role->name === 'Super Administrateur'
            ? \App\Models\School::all()
            : [];

        return view('programmes.form', compact('program', 'schools'));
    }

    public function update(ProgramRequest $request, Program $program)
    {
        $this->authorize('update', $program);

        $data = $request->validated();

        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier
            if ($program->file_path) {
                Storage::disk('public')->delete($program->file_path);
            }

            // Ajouter le nouveau fichier
            $data['file_path'] = $request->file('file')->store('programs', 'public');
            $data['file_type'] = $request->file('file')->getClientOriginalExtension();
        }

        $program->update($data);

        return redirect()->route('programmes.index')->with('success', 'Programme mis à jour avec succès.');
    }



    public function destroy(Program $program)
    {
        $this->authorize('delete', $program);
        $this->programService->delete($program);
        return redirect()->route('programmes.index')->with('success', 'Program deleted successfully.');
    }

    public function download($id)
    {
        $program = Program::findOrFail($id);

        if (!Storage::disk('public')->exists($program->file_path)) {
            return redirect()->route('programs.index')->with('error', 'Le fichier demandé est introuvable.');
        }

        return Storage::disk('public')->download($program->file_path);
    }

}
