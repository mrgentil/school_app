<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    // Afficher tous les roles (Super Administrateur uniquement)
    public function index()
    {
        if (Auth::user()->hasRole('Super Administrateur')) {
            $roles = Role::orderBy('created_at', 'desc')->get();
        } else {
            abort(403, 'Accès non autorisé');
        }

        return view('roles.index', compact('roles'));
    }

    // Ajouter un role (Super Administrateur uniquement)
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Super Administrateur')) {
            abort(403, 'Seul un Super Administrateur peut ajouter des roles');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Role ajouté avec succès'); // Rediriger vers la page d'accueil.index')->with('success', 'École ajoutée avec succès');
    }

    // Modifier un Role (Super Administrateur)
    public function update(Request $request, Role $role)
    {
        if (
            !Auth::user()->hasRole('Super Administrateur')
        ) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Role modifié avec succès');
    }

    // Supprimer un Role (Super Administrateur uniquement)
    public function destroy(Role $role)
    {
        if (!Auth::user()->hasRole('Super Administrateur')) {
            abort(403, 'Seul un Super Administrateur peut supprimer des écoles');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role supprimé avec succès'); // Rediriger vers la page d'accueil.index')->with('success', 'École supprimée avec succès');
    }

    // Afficher le formulaire pour créer une école (Super Administrateur uniquement)
    public function create()
    {
        if (!Auth::user()->hasRole('Super Administrateur')) {
            abort(403, 'Seul un Super Administrateur peut ajouter des roles');
        }

        return view('roles.form');
    }

    // Afficher les détails d'une école
    public function show(Role $role)
    {
        if (
            !Auth::user()->hasRole('Super Administrateur')

        ) {
            abort(403, 'Accès non autorisé');
        }

        return view('roles.show', compact('role'));
    }

    // Afficher le formulaire pour modifier une école
    public function edit(Role $role)
    {
        if (
            !Auth::user()->hasRole('Super Administrateur')
        ) {
            abort(403, 'Accès non autorisé');
        }

        return view('roles.form', compact('role'));
    }
}
