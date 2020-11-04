<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ServingController;
use App\Http\Controllers\TimingController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resources([
    'meals' => MealController::class,
    'servings' => ServingController::class,
    'timings' => TimingController::class,
    'ingredients' => IngredientController::class,
    'roles' => RoleController::class,
]);