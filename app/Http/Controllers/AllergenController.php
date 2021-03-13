<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\Allergen;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAllergenRequest;
use App\Http\Requests\UpdateAllergenRequest;

class AllergenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('allergen_access'), 403);

        $allergens = Allergen::all();

        return view('admin.allergens.index', compact('allergens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('allergen_create'), 403);

        return view('admin.allergens.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\StoreAllergenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAllergenRequest $request)
    {
        Allergen::create([
            'name' => $request['name'],
            'icon' => $request['icon'],
        ]);

        return redirect()->route('admin.allergens.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allergen  $allergen
     * @return \Illuminate\Http\Response
     */
    public function edit(Allergen $allergen)
    {
        abort_if(Gate::denies('allergen_edit'), 403);

        return view('admin.allergens.edit', compact('allergen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\UpdateAllergenRequest  $request
     * @param  \App\Models\Allergen  $allergen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAllergenRequest $request, Allergen $allergen)
    {
        $allergen->update([
            'name' => $request['name'],
            'icon' => $request['icon'],
        ]);

        return redirect()->route('admin.allergens.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allergen  $allergen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allergen $allergen)
    {
        abort_if(Gate::denies('allergen_delete'), 403);

        $allergen->delete();

        return redirect()->route('admin.allergens.index');
    }
}
