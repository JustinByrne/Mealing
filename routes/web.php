<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ServingController;

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

Route::post('/meals', [MealController::class, 'store'])->name('meals.store');
Route::get('/meals/{meal}', [MealController::class, 'show'])->name('meals.show');
Route::patch('/meals/{meal}', [MealController::class, 'update'])->name('meals.update');
Route::delete('/meals/{meal}', [MealController::class, 'destroy'])->name('meals.destroy');

Route::post('/servings', [ServingController::class, 'store'])->name('servings.store');
Route::get('/servings/{meal}', [ServingController::class, 'show'])->name('servings.show');