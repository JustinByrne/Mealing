<?php

namespace App\Http\Controllers;

use Gate;
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

    /**
     * Show dashboard page
     * 
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard');
    }

    /**
     * Show admin dashboard page
     * 
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {
        abort_if(Gate::denies('admin_access'), 403);
        
        return view('admin.dashboard');
    }
}
