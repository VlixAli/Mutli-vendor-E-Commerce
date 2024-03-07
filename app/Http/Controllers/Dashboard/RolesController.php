<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleStoreRequest;
use App\Http\Requests\Dashboard\RoleUpdateRequest;
use App\Models\Role;
use App\Models\RoleAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('roles.view');
        $roles = Role::paginate();
        return view('dashboard.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('roles.create');
        return view('dashboard.roles.create', [
            'role' => new Role()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        Gate::authorize('roles.create');
        $role = Role::createWithAbilities($request);

        return redirect()
            ->route('dashboard.roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('roles.update');
        $role_abilities = $role->abilities()->pluck('type', 'ability')->toArray();
        return view('dashboard.roles.edit', compact('role' , 'role_abilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        Gate::authorize('roles.update');
        $role->updateWithAbilities($request);

        return redirect()->route('dashboard.roles.index')
            ->with('success' , 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('roles.delete');
        Role::destroy($id);
        return redirect()->route('dashboard.roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
