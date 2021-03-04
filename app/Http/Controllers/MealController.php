<?php

namespace App\Http\Controllers;

use Auth;
use Gate;
use App\Models\Meal;
use App\Models\Allergen;
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

        $allergens = Allergen::all();

        return view('meals.create', compact('allergens'));
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

        foreach($request['allergens'] as $id => $level)    {
            if($level != 'no')  {
                $allergen = Allergen::find($id);
                $meal->allergens()->attach($allergen, ['level' => $level]);
            }
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

        $allergens = $meal->allergens()->pluck('level', 'allergen_id')->toArray();
        $allAllergens = Allergen::all();

        return view('meals.show', compact('meal', 'allAllergens', 'allergens'));
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

        $meal = Meal::with('ingredients', 'allergens')->where('slug', $meal)->first();

        $allergens = $meal->allergens()->pluck('level', 'allergen_id')->toArray();
        $allAllergens = Allergen::all();
        
        return view('meals.edit', compact('meal', 'allAllergens', 'allergens'));
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

        foreach($request['allergens'] as $id => $level)    {
            if ($meal->allergens->contains($id)) {
                if ($level != 'no') {
                    $meal->allergens()->updateExistingPivot($id, [
                        'level' => $level
                    ]);
                } else {
                    $meal->allergens()->detach($id);
                }
            } elseif ($level != 'no') {
                $allergen = Allergen::find($id);
                $meal->allergens()->attach($allergen, ['level' => $level]);
            }
        }

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
