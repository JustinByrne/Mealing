<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\Meal;
use App\Models\User;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    /**
     * Show homepage page
     * 
     * @return \Illuminate\View\View
     */
    public function homepage()
    {
        $topMeals = Meal::with('ratings', 'media')->withCount(['ratings as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(score),0)'));
        }])->orderByDesc('average_rating')->take(6)->get();
        
        return view('homepage', compact('topMeals'));
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
