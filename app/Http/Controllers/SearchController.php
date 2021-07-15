<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class SearchController extends Controller
{
    /**
     * @return Illuminate\View\View;
     * @return Illuminate\Http\RedirectResponse;
     */
    public function __invoke(Request $request)
    {
        if (! $request->has('s')) {
            abort(404);
        }

        $s = $request->s;
        
        if (Recipe::where('name', $s)->count() == 1) {
            return redirect()->route('recipes.show', Recipe::where('name', $s)->first());
        }

        $recipes = Recipe::with('ratings', 'media')
                        ->withCount(['ratings as rating' => function($query) {
                            $query->select(DB::raw('coalesce(avg(score),0)'));
                        }])
                        ->where('name', 'like', '%' . $s . '%')
                        ->orWhereHas('ingredients', function (Builder $query) use ($s) {
                            $query->where('name', 'like', '%' . $s . '%');
                        })
                        ->filter()->paginate(15);

        return view('search', compact('recipes', 's'));
    }
}
