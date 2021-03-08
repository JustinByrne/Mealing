<?php

namespace App\Http\Controllers;

use Auth;
use Gate;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;

class IngredientController extends Controller
{
    /**
     * Show all owned ingredients
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('ingredient_access'), 403);

        return view('ingredients.index');
    }

    /**
     * Show the form to create a new ingredient
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('ingredient_create'), 403);

        return view('ingredients.create');
    }
    
    /**
     * Create new ingredient
     * 
     * @param App\Http\Requests\StoreIngredientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIngredientRequest $request)
    {
        $ingredient = Auth::User()->Ingredients()->create($request->validated());

        return redirect($ingredient->path());
    }

    /**
     * Show the specified ingredient
     * 
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        abort_if(Gate::denies('ingredient_show'), 403);

        return view('ingredients.show', compact('ingredient'));
    }

    /**
     * Show the form to edit the specified ingredient
     * 
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingredient $ingredient)
    {
        abort_if(Gate::denies('ingredient_edit'), 403);

        abort_if($ingredient->user->id != \Auth::id(), 403);

        return view('ingredients.edit', compact('ingredient'));
    }

    /**
     * Update ingredient
     * 
     * @param App\Http\Requests\UpdateIngredientRequest $request
     * @param App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        abort_if($ingredient->user->id != \Auth::id(), 403);
        
        $ingredient->update($request->validated());

        return redirect($ingredient->path());
    }

    /**
     * Delete ingredient
     * 
     * @param App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        abort_if(Gate::denies('ingredient_delete'), 403);

        abort_if($ingredient->user->id != \Auth::id(), 403);
        
        $ingredient->delete();

        return redirect()->back();
    }
}
