<?php

namespace App\Http\Controllers;

use Auth;
use Gate;
use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;

class MealController extends Controller
{
    /**
     * Show all the meals
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('meal_access'), 403);

        return view('meals.index');
    }

    /**
     * Show all the meals
     * 
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        abort_if(Gate::denies('meal_access'), 403);

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
        abort_if(Gate::denies('meal_create'), 403);

        return view('meals.create');
    }
    
    /**
     * Create new meal
     * 
     * @param \App\Http\Requests\StoreMealRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMealRequest $request)
    {
        $meal = Auth::User()->Meals()->create([
            'name' => $request['name'],
            'servings' => $request['servings'],
            'adults' => $request->has('adults'),
            'kids' => $request->has('kids'),
            'timing' => $request['timing'],
            'instruction' => $request['instruction']
        ]);

        for($i = 0; $i < count($request['ingredients']); $i++)   {
            $ingredient = Ingredient::find($request['ingredients'][$i]);

            $meal->ingredients()->attach($ingredient, ['quantity' => $request['quantities'][$i]]);
        }

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
        abort_if(Gate::denies('meal_show'), 403);

        return view('meals.show', compact('meal'));
    }

    /**
     * Show the form to edit a meal
     * 
     * @param string $meal
     * @return \Illuminate\Http\Response
     */
    public function edit($meal)
    {
        abort_if(Gate::denies('meal_edit'), 403);

        $meal = Meal::with('ingredients')->where('slug', $meal)->first();
        
        return view('meals.edit', compact('meal'));
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
        abort_if(Gate::denies('meal_delete'), 403);
        
        $meal->delete();

        return redirect()->back();
    }
}
