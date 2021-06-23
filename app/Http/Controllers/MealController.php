<?php

namespace App\Http\Controllers;

use Auth;
use Gate;
use App\Models\Meal;
use App\Models\Allergen;
use App\Models\TempFile;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreMealRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateMealRequest;

class MealController extends Controller
{
    public function index(): View
    {
        abort_if(Gate::denies('meal_access'), 403);

        return view('meals.index');
    }

    public function create(): View
    {
        abort_if(Gate::denies('meal_create'), 403);

        $allergens = Allergen::all();

        return view('meals.create', compact('allergens'));
    }
    
    public function store(StoreMealRequest $request): RedirectResponse
    {
        $meal = Auth::User()->Meals()->create([
            'name' => $request['name'],
            'servings' => $request['servings'],
            'adults' => $request->has('adults'),
            'kids' => $request->has('kids'),
            'timing' => $request['timing'],
            'instruction' => $request['instruction']
        ]);

        $file = TempFile::where('folder', $request->image)->first();
        if ($file) {
            $meal->addMedia(Storage::path($request->image . '/' . $file->filename))->toMediaCollection();
            $file->delete();
        }

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

    public function show(Meal $meal): View
    {
        abort_if(Gate::denies('meal_show'), 403);

        $allergens = $meal->allergens()->pluck('level', 'allergen_id')->toArray();
        $allAllergens = Allergen::all();

        return view('meals.show', compact('meal', 'allAllergens', 'allergens'));
    }

    public function edit(Meal $meal): View
    {
        abort_if(Gate::denies('meal_edit'), 403);

        $meal->load('ingredients', 'allergens');

        $allergens = $meal->allergens()->pluck('level', 'allergen_id')->toArray();
        $allAllergens = Allergen::all();
        
        return view('meals.edit', compact('meal', 'allAllergens', 'allergens'));
    }

    public function update(UpdateMealRequest $request, Meal $meal): RedirectResponse
    {
        $meal->update($request->validated());

        $file = TempFile::where('folder', $request->image)->first();
        if ($file) {
            $mediaItems = $meal->getMedia();
            foreach ($mediaItems as $item) {
                $item->delete();
            }

            $meal->addMedia(Storage::path($request->image . '/' . $file->filename))->toMediaCollection();
            $file->delete();
        }

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

    public function destroy(Meal $meal): RedirectResponse
    {
        abort_if(Gate::denies('meal_delete'), 403);
        
        $meal->delete();

        return redirect()->back();
    }

    public function like(Meal $meal): RedirectResponse
    {
        abort_if(Gate::denies('meal_access'), 403);

        Auth()->user()->likedMeal()->attach($meal->id);

        return redirect()->route('meals.show', $meal);
    }

    public function unlike(Meal $meal): RedirectResponse
    {
        abort_if(Gate::denies('meal_access'), 403);

        DB::table('likes')->where('meal_id', $meal->id)->where('user_id', Auth()->id())->delete();

        return redirect()->route('meals.show', $meal);
    }
}
