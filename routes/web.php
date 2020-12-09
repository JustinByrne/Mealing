<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ServingController;
use App\Http\Controllers\TimingController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;

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

Route::middleware(['guest'])->group(function()  {
    Route::get('/', [PagesController::class, 'landing'])->name('landing');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerStore'])->name('register.store');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/ingredients/all', [IngredientController::class, 'index'])->name('ingredients.all');
    Route::get('/meals/all', [MealController::class, 'all'])->name('meals.all');

    Route::resources([
        'meals' => MealController::class,
        'servings' => ServingController::class,
        'timings' => TimingController::class,
        'ingredients' => IngredientController::class,
        'roles' => RoleController::class,
        'permissions' => PermissionController::class,
        'users' => UserController::class,
    ]);
});