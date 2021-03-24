<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\Meal;
use App\Models\User;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Show homepage page
     * 
     * @return \Illuminate\View\View
     */
    public function homepage()
    {
        return view('homepage');
    }

    /**
     * Show admin dashboard page
     * 
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {
        abort_if(Gate::denies('admin_access'), 403);

        $users = User::count();
        $meals = Meal::count();
        $ingredients = Ingredient::count();
        
        return view('admin.dashboard', compact('users', 'meals', 'ingredients'));
    }
}
