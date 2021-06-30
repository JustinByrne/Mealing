<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\Allergen;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreAllergenRequest;
use App\Http\Requests\UpdateAllergenRequest;

class AllergenController extends Controller
{
    public function index() : View
    {
        abort_if(Gate::denies('allergen_access'), 403);

        $allergens = Allergen::all();

        return view('admin.allergens.index', compact('allergens'));
    }

    public function create(): View
    {
        abort_if(Gate::denies('allergen_create'), 403);

        return view('admin.allergens.create');
    }

    public function store(StoreAllergenRequest $request): RedirectResponse
    {
        Allergen::create($request->validated());

        return redirect()->route('admin.allergens.index');
    }

    public function edit(Allergen $allergen): View
    {
        abort_if(Gate::denies('allergen_edit'), 403);

        return view('admin.allergens.edit', compact('allergen'));
    }

    public function update(UpdateAllergenRequest $request, Allergen $allergen): RedirectResponse
    {
        $allergen->update($request->validated());

        return redirect()->route('admin.allergens.index');
    }

    public function destroy(Allergen $allergen): RedirectResponse
    {
        abort_if(Gate::denies('allergen_delete'), 403);

        $allergen->delete();

        return redirect()->route('admin.allergens.index');
    }
}
