<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ServingController;
use App\Http\Controllers\TimingController;

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
Route::get('/servings/{serving}', [ServingController::class, 'show'])->name('servings.show');
Route::patch('/servings/{serving}', [ServingController::class, 'update'])->name('servings.update');
Route::delete('/servings/{serving}', [ServingController::class, 'destroy'])->name('servings.destroy');

Route::post('/timings', [TimingController::class, 'store'])->name('timing.store');
Route::get('/timings/{timing}', [TimingController::class, 'show'])->name('timing.show');
Route::patch('/timings/{timing}', [TimingController::class, 'update'])->name('timing.update');
Route::delete('/timings/{timing}', [TimingController::class, 'destroy'])->name('timing.destroy');