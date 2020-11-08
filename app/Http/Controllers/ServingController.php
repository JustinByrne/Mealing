<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreServingRequest;
use App\Http\Requests\UpdateServingRequest;
use App\Models\Serving;
use Gate;

class ServingController extends Controller
{
    /**
     * Show all the servings
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('serving_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servings = Serving::all();
    }

    /**
     * Show the form to create a serving
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('serving_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
    
    /**
     * Create new Serving
     * 
     * @param \App\Http\Requests\StoreServingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServingRequest $request)
    {
        $serving = Serving::create($request->validated());

        return redirect($serving->path());
    }

    /**
     * Show all the individual serving
     * 
     * @param \App\Models\Serving $serving
     * @return \Illuminate\Http\Response
     */
    public function show(Serving $serving)
    {
        abort_if(Gate::denies('serving_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Show the form to edit a serving
     * 
     * @param \App\Models\Serving $serving
     * @return \Illuminate\Http\Response
     */
    public function edit(Serving $serving)
    {
        abort_if(Gate::denies('serving_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Update existing serving
     * 
     * @param \App\Http\Requests\UpdateServingRequest  $request
     * @param \App\Models\Serving $serving
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServingRequest $request, Serving $serving)
    {
        $serving->update($request->validated());

        return redirect($serving->path());
    }

    /**
     * Delete existing serving
     * 
     * @param \App\Models\Serving $serving
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serving $serving)
    {
        abort_if(Gate::denies('serving_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $serving->delete();
    }
}
