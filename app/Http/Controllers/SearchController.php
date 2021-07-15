<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(String $s)
    {
        if (Recipe::where('name', $s)->count() == 1) {
            return redirect()->route('recipes.show', Recipe::where('name', $s)->first());
        }

        $recipes = Recipe::where('name', 'like', '%' . $s . '%')->get();

        return $recipes;
    }
}
