<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AllergenController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PermissionController;

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
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/user/profile/settings/account', [ProfileController::class, 'accountSettings'])->name('profile.settings.account');
    Route::patch('/user/profile/settings/account', [ProfileController::class, 'update']);
    Route::post('/user/profile/settings/account/password', [ProfileController::class, 'password'])->name('profile.settings.password');
    Route::get('/user/profile/settings/security', [ProfileController::class, 'securitySettings'])->name('profile.settings.security');

    Route::get('/ingredients/all', [IngredientController::class, 'index'])->name('ingredients.all');
    Route::get('/meals/all', [MealController::class, 'all'])->name('meals.all');

    Route::prefix('admin')->name('admin.')->group(function()   {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('allergens', AllergenController::class)->except('show');
        Route::resource('users', UserController::class)->except('show');
    });

    Route::resources([
        'meals' => MealController::class,
        'ingredients' => IngredientController::class,
    ]);
});