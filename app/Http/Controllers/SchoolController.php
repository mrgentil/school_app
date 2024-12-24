<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\School;

class SchoolController extends Controller
{
    // Afficher toutes les écoles (Super Administrateur uniquement)
    public function index()
    {
        if (Auth::user()->hasRole('Super Administrateur')) {
            $schools = School::all(); // Super Administrateur voit tout
        } elseif (Auth::user()->hasRole('Administrateur')) {
            $schools = School::where('id', Auth::user()->school_id)->get(); // Administrateur voit seulement son école
        } else {
            abort(403, 'Accès non autorisé');
        }

        return view('schools.index', compact('schools'));
    }

    // Ajouter une école (Super Administrateur uniquement)
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Super Administrateur')) {
            abort(403, 'Seul un Super Administrateur peut ajouter des écoles');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'adress' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        School::create($validated);

        return redirect()->route('schools.index')->with('success', 'École ajoutée avec succès');
    }

    // Modifier une école (Super Administrateur ou Administrateur pour leur propre école)
    public function update(Request $request, School $school)
    {
        if (
            !Auth::user()->hasRole('Super Administrateur') &&
            (!Auth::user()->hasRole('Administrateur') || Auth::user()->school_id !== $school->id)
        ) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'adress' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $school->update($validated);

        return redirect()->route('schools.index')->with('success', 'École modifiée avec succès');
    }

     // Supprimer une école (Super Administrateur uniquement)
     public function destroy(School $school)
     {
         if (!Auth::user()->hasRole('Super Administrateur')) {
             abort(403, 'Seul un Super Administrateur peut supprimer des écoles');
         }

         $school->delete();

         return redirect()->route('schools.index')->with('success', 'École supprimée avec succès');
     }

     // Afficher le formulaire pour créer une école (Super Administrateur uniquement)
    public function create()
    {
        if (!Auth::user()->hasRole('Super Administrateur')) {
            abort(403, 'Seul un Super Administrateur peut ajouter des écoles');
        }

        return view('schools.form');
    }

    // Afficher les détails d'une école
    public function show(School $school)
    {
        if (
            !Auth::user()->hasRole('Super Administrateur') &&
            (!Auth::user()->hasRole('Administrateur') || Auth::user()->school_id !== $school->id)
        ) {
            abort(403, 'Accès non autorisé');
        }

        return view('schools.show', compact('school'));
    }

    // Afficher le formulaire pour modifier une école
public function edit(School $school)
{
    if (
        !Auth::user()->hasRole('Super Administrateur') &&
        (!Auth::user()->hasRole('Administrateur') || Auth::user()->school_id !== $school->id)
    ) {
        abort(403, 'Accès non autorisé');
    }

    return view('schools.form', compact('school'));
}

}

