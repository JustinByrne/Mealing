<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreServing;
use App\Models\Serving;

class ServingController extends Controller
{
    /**
     * Create new meal
     * 
     * @param \App\Http\Requests\StoreServing  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServing $request)
    {
        $serving = Serving::create($request->validated());

        return redirect($serving->path());
    }
}
