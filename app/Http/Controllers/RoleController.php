<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('role_access'), 403);

        return view('admin.roles.index');
    }

    public function create(): View
    {
        abort_if(Gate::denies('role_create'), 403);

        return view('admin.roles.create');
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());

        return redirect()->route('admin.roles.show', [$role]);
    }

    public function show(Role $role): View
    {
        abort_if(Gate::denies('role_show'), 403);

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role): View
    {
        abort_if(Gate::denies('role_edit'), 403);

        return view('admin.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return redirect()->route('admin.roles.show', [$role]);
    }

    public function destroy(Role $role): void
    {
        abort_if(Gate::denies('role_delete'), 403);
        
        $role->delete();
    }
}
