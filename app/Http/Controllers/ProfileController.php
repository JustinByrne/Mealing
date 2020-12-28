<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends Controller
{
    /**
     * Profile page to disaply user details
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('user.profile.index', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Profile page to disaply user account settings
     * 
     * @return \Illuminate\Http\Response
     */
    public function accountSettings()
    {
        return view('user.profile.account', [
            'user' => Auth::user(),
        ]);
    }
    
    /**
     * Get 2FA page
     * 
     * @return \Illuminate\Http\Response
     */
    public function securitySettings()
    {
        return view('user.profile.security', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update profile
     * 
     * @param App\Http\Requests\UpdateAccountRequest $request
     * @return Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('name', 'email'));

        return redirect(route('profile.settings.account'));
    }

    /**
     * Updating users password
     * 
     * @param App\Http\Requests\ChangePasswordRequest $request
     * @return Illuminate\Http\Response
     */
    public function password(ChangePasswordRequest $request)
    {
        $user = Auth::User();

        $user->update([
            'password' => Hash::make($request['password'])
        ]);

        return redirect(route('profile.settings.account'))->with('passwordStatus', 'Password Changed Successfully');
    }
}
