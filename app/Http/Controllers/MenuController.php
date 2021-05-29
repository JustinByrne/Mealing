<?php

namespace App\Http\Controllers;

use Gate;
use Carbon\Carbon;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        abort_if(Gate::denies('menu_access'), 403);

        if (! $request->has('week_start')) {
            $date = Carbon::now()->startOfWeek();
            $links = [
                'prev' => Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'),
                'next' => Carbon::now()->addWeek()->startOfWeek()->format('Y-m-d')
            ];
        } else {
            $date = Carbon::parse($request->query('week_start'))->startOfWeek();
            $links = [
                'prev' => Carbon::parse($request->query('week_start'))->subWeek()->startOfWeek()->format('Y-m-d'),
                'next' => Carbon::parse($request->query('week_start'))->addWeek()->startOfWeek()->format('Y-m-d')
            ];
        }

        $weekDays = [
            'Monday' => $date->format('Y-m-d'),
            'Tuesday' => $date->addDay()->format('Y-m-d'),
            'Wednesday' => $date->addDay()->format('Y-m-d'),
            'Thursday' => $date->addDay()->format('Y-m-d'),
            'Friday' => $date->addDay()->format('Y-m-d'),
            'Saturday' => $date->addDay()->format('Y-m-d'),
            'Sunday' => $date->addDay()->format('Y-m-d'),
        ];

        $current = Menu::with('meals', 'meals.ingredients')->whereHas('meals', function ($query) use ($date, $weekDays) {
            $query->whereIn('date', $weekDays);
        })->where('user_id', Auth::id())->first();

        return view('menus.index', compact('weekDays', 'current', 'links'));
    }

    public function create(Request $request): View
    {
        abort_if(Gate::denies('menu_create'), 403);

        return view('menus.create');
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
