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
