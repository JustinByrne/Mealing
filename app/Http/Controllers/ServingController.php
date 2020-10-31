<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreServingRequest;
use App\Http\Requests\UpdateServingRequest;
use App\Models\Serving;

class ServingController extends Controller
{
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
        $serving->delete();
    }
}
