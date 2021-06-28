<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    public function homepage(): View
    {
        $topRecipes = Recipe::with('ratings', 'media')->withCount(['ratings as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(score),0)'));
        }])->orderByDesc('average_rating')->take(6)->get();
        
        return view('homepage', compact('topRecipes'));
    }

    public function adminDashboard(): View
    {
        abort_if(Gate::denies('admin_access'), 403);

        $users = User::count();
        $recipes = Recipe::count();
        $ingredients = Ingredient::count();
        
        return view('admin.dashboard', compact('users', 'recipes', 'ingredients'));
    }
}
