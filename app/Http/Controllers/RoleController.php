<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->middleware('auth');
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        try {
            $roles = $this->roleService->getAllRoles();
            return view('roles.index', compact('roles'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des rôles: ' . $e->getMessage());
            return back()->withErrors('Une erreur est survenue lors du chargement des rôles.');
        }
    }

    public function create()
    {
        return view('roles.form');
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleService->createRole($request->validated());
            return redirect()
                ->route('roles.index')
                ->with('success', 'Rôle créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création rôle: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors('Une erreur est survenue lors de la création du rôle.');
        }
    }

    public function edit(Role $role)
    {
        return view('roles.form', compact('role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        try {
            $this->roleService->updateRole($role, $request->validated());
            return redirect()
                ->route('roles.index')
                ->with('success', 'Rôle modifié avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur modification rôle: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors('Une erreur est survenue lors de la modification du rôle.');
        }
    }

    public function destroy(Role $role)
    {
        try {
            $this->roleService->deleteRole($role);
            return redirect()
                ->route('roles.index')
                ->with('success', 'Rôle supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression rôle: ' . $e->getMessage());
            return back()->withErrors($e->getMessage());
        }
    }
}
