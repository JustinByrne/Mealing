<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
     * Get 2FA page
     * 
     * @return \Illuminate\Http\Response
     */
    public function twoFactorAuthPage()
    {
        return view('user.profile.2fa', [
            'user' => Auth::user(),
        ]);
    }
}
