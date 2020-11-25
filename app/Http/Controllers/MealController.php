<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Models\Meal;
use Gate;

class MealController extends Controller
{
    /**
     * Show all the meals
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('meal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meals = Meal::all();

        return view('meals.index', compact('meals'));
    }

    /**
     * Show the form to create a meal
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('meal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
    
    /**
     * Create new meal
     * 
     * @param \App\Http\Requests\StoreMealRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMealRequest $request)
    {
        $meal = Meal::create($request->validated());

        return redirect($meal->path());
    }

    /**
     * Show the specified meal
     * 
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        abort_if(Gate::denies('meal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Show the form to edit a meal
     * 
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\Response
     */
    public function edit(Meal $meal)
    {
        abort_if(Gate::denies('meal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Update existing meal
     * 
     * @param \App\Http\Requests\UpdateMealRequest  $request
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMealRequest $request, Meal $meal)
    {
        $meal->update($request->validated());

        return redirect($meal->path());
    }

    /**
     * Delete existing meal
     * 
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        abort_if(Gate::denies('meal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $meal->delete();

        return redirect()->back();
    }
}
