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
}
