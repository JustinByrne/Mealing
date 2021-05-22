<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(): void
    {
        abort_if(Gate::denies('menu_access'), 403);

        //
    }
}
