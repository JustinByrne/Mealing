<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('permission_access'), 403);

        return view('admin.permissions.index');
    }

    public function show(Permission $permission): View
    {
        abort_if(Gate::denies('permission_show'), 403);

        $permission->load('roles');

        return view('admin.permissions.show', compact('permission'));
    }
}
