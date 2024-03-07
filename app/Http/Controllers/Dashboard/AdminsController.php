<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminStoreRequest;
use App\Http\Requests\Dashboard\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::paginate();
        return view('dashboard.admins.index', [
            'admins' => $admins
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admins.create', [
            'roles' => Role::all(),
            'admin' => new Admin()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStoreRequest $request)
    {
        $admin = Admin::create($request->validated());
        $admin->roles()->attach($request->roles);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin created successfully');
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
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        $admin_roles = $admin->roles()->pluck('id')->toArray();

        return view('dashboard.admins.edit', compact('admin', 'roles', 'admin_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        $admin->update($request->validated());
        $admin->roles()->sync($request->roles);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Admin::destroy($id);
        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin deleted successfully');
    }
}
