<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    /**
     * Create new ingredient
     * 
     * @param App\Http\Requests\StoreIngredientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIngredientRequest $request)
    {
        $ingredient = Ingredient::create($request->validated());

        return redirect($ingredient->path());
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
        $ingredient->delete();
    }
}
