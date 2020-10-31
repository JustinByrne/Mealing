<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTimingRequest;
use App\Http\Requests\UpdateTimingRequest;
use App\Models\Timing;

class TimingController extends Controller
{
    /**
     * Create new timing
     * 
     * @param \App\Http\Requests\StoreTimingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimingRequest $request)
    {
        $timing = Timing::create($request->validated());

        return redirect($timing->path());
    }
}
