<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\School;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        if ($currentUser->hasRole('Super Administrateur')) {
            // Super Administrateur voit tous les utilisateurs
            $users = User::with('role', 'school')->get();
        } elseif ($currentUser->hasRole('Administrateur')) {
            // Administrateur voit uniquement les utilisateurs de son école
            $users = User::with('role', 'school')->where('school_id', $currentUser->school_id)->get();
        } else {
            abort(403, 'Accès interdit');
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $currentUser = auth()->user();

        if ($currentUser->hasRole('Super Administrateur')) {
            // Super Administrateur peut assigner tous les rôles et voir toutes les écoles
            $roles = Role::all();
            $schools = School::all();
        } elseif ($currentUser->hasRole('Administrateur')) {
            // Administrateur ne peut pas assigner le rôle de Super Administrateur
            $roles = Role::where('name', '!=', 'Super Administrateur')->get();
            $schools = School::where('id', $currentUser->school_id)->get();
        } else {
            abort(403, 'Accès interdit');
        }

        return view('users.form', compact('roles', 'schools'));
    }

    // Méthode store
    public function store(Request $request)
    {
        $currentUser = auth()->user();

        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'adress' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'school_id' => 'required|exists:schools,id',
        ]);

        try {
            // Vérification des permissions du rôle assigné
            if ($currentUser->hasRole('Administrateur')) {
                $superAdminRoleId = Role::where('name', 'Super Administrateur')->first()->id;
                if ($validatedData['role_id'] == $superAdminRoleId) {
                    return redirect()->back()->withErrors(['error' => 'Vous ne pouvez pas assigner le rôle de Super Administrateur.']);
                }

                // Assurez-vous que l'administrateur ajoute des utilisateurs dans sa propre école
                if ($validatedData['school_id'] != $currentUser->school_id) {
                    return redirect()->back()->withErrors(['error' => 'Vous ne pouvez ajouter des utilisateurs que dans votre école.']);
                }
            }

            // Création de l'utilisateur
            $user = new User($validatedData);
            $user->password = Hash::make('password'); // Mot de passe temporaire
            $user->created_by = $currentUser->id;

            // Gestion de l'avatar
            if ($request->hasFile('avatar')) {
                $user->avatar = $request->file('avatar')->store('avatars', 'public');
            }

            $user->save();

            // Création du token pour la réinitialisation du mot de passe
            $token = Password::createToken($user);

            // Envoi de l'email pour définir le mot de passe
            $user->notify(new ResetPasswordNotification($token));

            return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès. Un email a été envoyé pour définir le mot de passe.');

        } catch (\Exception $e) {
            // Log l'erreur pour le diagnostic
            Log::error('Erreur lors de l\'ajout de l\'utilisateur : ' . $e->getMessage());

            // Retourne un message d'erreur à la vue
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de l\'ajout de l\'utilisateur. Veuillez réessayer.']);
        }
    }
    public function edit(User $user)
    {
        $currentUser = auth()->user();

        if ($currentUser->hasRole('Super Administrateur')) {
            $roles = Role::all();
            $schools = School::all();
        } elseif ($currentUser->hasRole('Administrateur')) {
            if ($user->school_id != $currentUser->school_id) {
                abort(403, 'Accès interdit.');
            }

            $roles = Role::where('name', '!=', 'Super Administrateur')->get();
            $schools = School::where('id', $currentUser->school_id)->get();
        } else {
            abort(403, 'Accès interdit');
        }

        return view('users.form', compact('user', 'roles', 'schools'));
    }

    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'school_id' => 'required|exists:schools,id',
        ]);

        $assignedRole = Role::find($request->role_id);

        if ($currentUser->hasRole('Administrateur')) {
            if ($assignedRole->name === 'Super Administrateur') {
                return back()->with('error', 'Vous ne pouvez pas assigner le rôle de Super Administrateur.');
            }

            if ($user->school_id != $currentUser->school_id || $request->school_id != $currentUser->school_id) {
                return back()->with('error', 'Vous ne pouvez modifier que les utilisateurs de votre école.');
            }
        }

        $user->fill($request->except('password', 'avatar'));

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(User $user)
    {
        $currentUser = auth()->user();

        if ($currentUser->hasRole('Administrateur') && $user->school_id != $currentUser->school_id) {
            abort(403, 'Vous ne pouvez supprimer que les utilisateurs de votre école.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
