<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Gate;

class RoleController extends Controller
{
    /**
     * Show all the roles
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();
    }

    /**
     * Show the form to create a role
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Create new role
     * 
     * @param App\Http\Requests\StoreRoleRequest $request
     * @return Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());

        return redirect($role->path());
    }

    /**
     * Show the specified role
     * 
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Show the form to edit a role
     * 
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Update a role
     * 
     * @param App\Http\Requests\UpdateRoleRequest $request
     * @param App\Models\Role $role
     * @return Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return redirect($role->path());
    }

    /**
     * Delete a role
     * 
     * @param App\Models\Role $role
     * @return Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $role->delete();
    }
}
