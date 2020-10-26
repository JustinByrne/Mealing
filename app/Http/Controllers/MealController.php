<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMeal;
use App\Models\Meal;

class MealController extends Controller
{
    /**
     * Create new meal
     * 
     * @param \App\Http\Requests\StoreMeal  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMeal $request)
    {
        $meal = Meal::create($request->validated());
    }

    /**
     * Update existing meal
     * 
     * @param \App\Http\Requests\StoreMeal  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMeal $request, Meal $meal)
    {
        $meal->update($request->validated());
    }
}
