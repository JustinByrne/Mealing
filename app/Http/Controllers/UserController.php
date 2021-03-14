<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Show all the users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Create new user form
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.users.create');
    }

    /**
     * Store new user
     * 
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return redirect($user->path());
    }

    /**
     * Show the individual user
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Edit user form
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update existing user
     * 
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect($user->path());
    }

    /**
     * Delete existing user
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $user->delete();
    }
}
