<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Show landing page
     * 
     * @return \Illuminate\View\View
     */
    public function landing()
    {
        return view('landing');
    }
}