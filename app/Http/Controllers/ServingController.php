<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreServing;
use App\Models\Serving;

class ServingController extends Controller
{
    /**
     * Create new Serving
     * 
     * @param \App\Http\Requests\StoreServing  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServing $request)
    {
        $serving = Serving::create($request->validated());

        return redirect($serving->path());
    }

    /**
     * Update existing serving
     * 
     * @param \App\Http\Requests\StoreServing  $request
     * @param \App\Models\Serving $serving
     * @return \Illuminate\Http\Response
     */
    public function update(StoreServing $request, Serving $serving)
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
