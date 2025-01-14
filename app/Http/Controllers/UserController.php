<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\School;
use App\Http\Requests\UserRequest; // Nouveau
use App\Services\UserService; // Nouveau
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Log, Password};

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
        $this->middleware('can:manage-users');
    }

    /**
     * Affiche la liste des utilisateurs
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    $currentUser = auth()->user();
    $users = $this->userService->getUsersList($currentUser, [
        'id' => request('id'),
        'name' => request('name'),
        'school' => request('school')
    ]);

    return view('users.index', compact('users'));
}

    /**
     * Affiche le formulaire de création
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $currentUser = auth()->user();
        [$roles, $schools] = $this->userService->getFormData($currentUser);

        return view('users.form', compact('roles', 'schools'));
    }

    /**
     * Enregistre un nouvel utilisateur
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        try {
            $currentUser = auth()->user();
            $this->userService->validateUserCreation($request->validated(), $currentUser);

            $user = $this->userService->createUser($request, $currentUser);

            // Envoi du mail de réinitialisation du mot de passe
            $token = Password::createToken($user);
            $user->notify(new ResetPasswordNotification($token));

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur ajouté avec succès. Un email a été envoyé pour définir le mot de passe.');

        } catch (\Exception $e) {
            Log::error('Erreur création utilisateur: ' . $e->getMessage(), [
                'user_id' => $currentUser->id,
                'data' => $request->except('password')
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de l\'ajout de l\'utilisateur.']);
        }
    }

    public function edit(User $user)
{
    $currentUser = auth()->user();
    $this->authorize('update', $user); // Ajouter cette ligne

    [$roles, $schools] = $this->userService->getFormData($currentUser);

    return view('users.form', compact('user', 'roles', 'schools'));
}

public function update(UserRequest $request, User $user)
{
    try {
        $currentUser = auth()->user();
        $this->authorize('update', $user); // Ajouter cette ligne

        $this->userService->updateUser($user, $request, $currentUser);

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la modification.']);
    }
}

    /**
     * Supprime un utilisateur
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            $currentUser = auth()->user();
            $this->authorize('delete', [$user, $currentUser]);

            $this->userService->deleteUser($user);

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur supprimé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur suppression utilisateur: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'deleter_id' => $currentUser->id
            ]);

            return redirect()
                ->back()
                ->withErrors(['error' => 'Une erreur est survenue lors de la suppression.']);
        }
    }

    /**
     * Recherche des utilisateurs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try {
            $query = User::with(['role', 'school'])
                ->orderBy('created_at', 'desc');

            // Filtre par école pour les administrateurs
            if (auth()->user()->hasRole('Administrateur')) {
                $query->where('school_id', auth()->user()->school_id);
            }

            // Appliquer les filtres de recherche
            if ($request->filled('search_id')) {
                $query->where('id', 'like', '%' . $request->search_id . '%');
            }

            if ($request->filled('search_name')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search_name . '%')
                        ->orWhere('first_name', 'like', '%' . $request->search_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search_name . '%');
                });
            }

            if ($request->filled('search_school')) {
                $query->whereHas('school', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search_school . '%');
                });
            }

            // Journaliser la requête SQL et les bindings
            Log::info($query->toSql());
            Log::info($query->getBindings());

            $users = $query->get();

            return response()->json([
                'users' => $users,
                'html' => view('users.users-table', compact('users'))->render(),
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur dans la recherche d\'utilisateurs : ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Une erreur est survenue lors de la recherche.',
            ], 500);
        }
    }

}
