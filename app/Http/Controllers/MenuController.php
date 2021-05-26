<?php

namespace App\Http\Controllers;

use Gate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class MenuController extends Controller
{
    public function index(): void
    {
        abort_if(Gate::denies('menu_access'), 403);

        //
    }

    public function create(): void
    {
        abort_if(Gate::denies('menu_create'), 403);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(Gate::denies('menu_create'), 403);

        $menu = Auth::user()->menus()->create();

        $wc = Carbon::parse($request->input('wc', Carbon::now()->startOfWeek()->format('Y-m-d H:i')));

        $days = [
            'monday' => 0,
            'tuesday' => 1,
            'wednesday' =>2,
            'thursday' =>3,
            'friday' => 4,
            'saturday' => 5,
            'sunday' => 6
        ];

        foreach ($days as $day => $add) {
            if (! is_null($request->input($day))) {
                $menu->meals()->attach($request->input($day), ['date' => $wc]);
            }
            $wc->addDay();
        }

        return redirect()->route('menus.index');
    }
}
