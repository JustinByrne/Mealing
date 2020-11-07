<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreTimingRequest;
use App\Http\Requests\UpdateTimingRequest;
use App\Models\Timing;
use Gate;

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

    /**
     * Update timing
     * 
     * @param \App\Http\Requests\UpdateTimingRequest $request
     * @param \App\Models\Timing $timing
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTimingRequest $request, Timing $timing)
    {
        $timing->update($request->validated());

        return redirect($timing->path());
    }

    /**
     * Delete timing
     * 
     * @param \App\Models\Timing $timing
     * @return void
     */
    public function destroy(Timing $timing)
    {
        abort_if(Gate::denies('timing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $timing->delete();
    }
}
