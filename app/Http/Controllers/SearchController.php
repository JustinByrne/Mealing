<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SearchController extends Controller
{
    public function __invoke(String $s)
    {
        if (Recipe::where('name', $s)->count() == 1) {
            return redirect()->route('recipes.show', Recipe::where('name', $s)->first());
        }

        $recipes = Recipe::where('name', 'like', '%' . $s . '%')
                        ->orWhereHas('ingredients', function (Builder $query) use ($s) {
                            $query->where('name', 'like', '%' . $s . '%');
                        })
                        ->get();

        return $recipes;
    }
}
