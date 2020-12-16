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
}
