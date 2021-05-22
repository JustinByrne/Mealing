<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function profile(): View
    {
        return view('user.profile.index');
    }

    public function accountSettings(): View
    {
        return view('user.profile.account');
    }
    
    public function securitySettings(): View
    {
        return view('user.profile.security');
    }

    public function update(UpdateAccountRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->email != $request['email'])  {
            $user->update([
                'email_verified_at' => null,
            ]);
        }

        $user->update($request->only('name', 'email'));

        return redirect(route('profile.settings.account'))->with('profileStatus', 'Account Successfully Updated');
    }

    public function password(ChangePasswordRequest $request): RedirectResponse
    {
        $user = Auth::User();

        $user->update([
            'password' => Hash::make($request['password'])
        ]);

        return redirect(route('profile.settings.account'))->with('passwordStatus', 'Password Changed Successfully');
    }
}
