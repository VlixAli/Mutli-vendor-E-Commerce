<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserStoreRequest;
use App\Http\Requests\Dashboard\UserUpdateRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('users.view');
        $users = User::paginate();
        return view('dashboard.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('users.create');
        return view('dashboard.users.create', [
            'roles' => Role::all(),
            'user' => new User()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        Gate::authorize('users.create');
        $user = User::create($request->validated());
        $user->roles()->attach($request->roles);

        return redirect()
            ->route('dashboard.users.index')
            ->with('success', 'User created successfully');
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
    public function edit(User $user)
    {
        Gate::authorize('users.update');
        $roles = Role::all();
        $user_roles = $user->roles()->pluck('id')->toArray();

        return view('dashboard.users.edit', compact('user', 'roles', 'user_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        Gate::authorize('users.update');
        $user->update($request->validated());
        $user->roles()->sync($request->roles);

        return redirect()
            ->route('dashboard.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('users.delete');
        User::destroy($id);
        return redirect()
            ->route('dashboard.users.index')
            ->with('success', 'User deleted successfully');
    }
}
