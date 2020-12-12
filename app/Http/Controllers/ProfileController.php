<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get 2FA page
     * 
     * @return view
     */
    public function twoFactorAuthPage()
    {
        return view('user.profile.2fa');
    }
}
