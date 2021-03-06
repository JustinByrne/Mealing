<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    /**
     * Show all the permissions
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('permission_access'), 403);

        return view('admin.permissions.index');
    }

    /**
     * Show the form to create a permission
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('permission_create'), 403);

        return view('admin.permissions.create');
    }

    /**
     * Create new permission
     * 
     * @param \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->validated());

        return redirect()->route('admin.permissions.show', [$permission]);
    }

    /**
     * Show the specified permission
     * 
     * @param int $permission
     * @return \Illuminate\Http\Response
     */
    public function show(int $permission)
    {
        abort_if(Gate::denies('permission_show'), 403);

        $permission = Permission::with('roles')->find($permission);

        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form to edit a permission
     * 
     * @param \Spatie\Permission\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), 403);

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update existing permission
     * 
     * @param \App\Http\Requests\UpdatePermissionRequest $request
     * @param \Spatie\Permission\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        return redirect()->route('admin.permissions.show', [$permission]);
    }

    /**
     * Delete existing permission
     * 
     * @param \Spatie\Permission\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), 403);
        
        $permission->delete();
    }
}
