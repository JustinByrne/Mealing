<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use Gate;
use Auth;

class IngredientController extends Controller
{
    /**
     * Show all owned ingredients
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('ingredient_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('ingredients.index');
    }

    /**
     * Show the form to create a new ingredient
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('ingredient_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('ingredient_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('ingredient_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('ingredient_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        abort_if($ingredient->user->id != \Auth::id(), 403);
        
        $ingredient->delete();

        return redirect()->back();
    }
}
