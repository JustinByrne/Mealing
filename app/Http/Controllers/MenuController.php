<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
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

        return redirect()->route('menus.index');
    }
}
