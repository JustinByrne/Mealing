<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    /**
     * Display registration form
     * 
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Register new user
     * 
     * @param App\Http\Requests\StoreRegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function registerStore(StoreRegisterRequest $request)
    {
        $user = User::create($request->validated());

        $userRole = Role::find(2);

        $user->roles()->sync($userRole);

        Auth::login($user);

        return redirect(route('dashboard'));
    }

    /**
     * Display login form
     * 
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate user
     * 
     * @param App\Http\Requests\AuthLoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(AuthLoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            return redirect(route('dashboard'));
        }

        return back()->withErrors([
            'failed' => 'Incorrect email or password.',
            'email' => true,
            'password' => true,
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('landing'));
    }
}
