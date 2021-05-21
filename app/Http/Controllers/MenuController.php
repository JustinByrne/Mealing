<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * show all menus
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('menu_access'), 403);

        //
    }
}
