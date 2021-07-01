<?php

namespace App\Http\Controllers;

use Auth;
use Gate;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;

class IngredientController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('ingredient_access'), 403);

        return view('admin.ingredients.index');
    }

    public function create(): View
    {
        abort_if(Gate::denies('ingredient_create'), 403);

        return view('admin.ingredients.create');
    }
    
    public function store(StoreIngredientRequest $request): RedirectResponse
    {
        $ingredient = Auth::User()->Ingredients()->create($request->validated());

        return redirect($ingredient->path());
    }

    public function show(Ingredient $ingredient): View
    {
        abort_if(Gate::denies('ingredient_show'), 403);

        $ingredient->load('recipes.media', 'recipes.ratings');

        return view('admin.ingredients.show', compact('ingredient'));
    }

    public function edit(Ingredient $ingredient): View
    {
        abort_if(Gate::denies('ingredient_edit'), 403);

        abort_if($ingredient->user->id != \Auth::id(), 403);

        return view('admin.ingredients.edit', compact('ingredient'));
    }

    public function update(UpdateIngredientRequest $request, Ingredient $ingredient): RedirectResponse
    {
        abort_if($ingredient->user->id != \Auth::id(), 403);
        
        $ingredient->update($request->validated());

        return redirect($ingredient->path());
    }

    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        abort_if(Gate::denies('ingredient_delete')
            || $ingredient->user_id != \Auth::id(), 403);

        $ingredient->delete();

        return redirect()->route('admin.ingredients.index');
    }
}
