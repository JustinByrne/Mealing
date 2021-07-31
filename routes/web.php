<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
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

Route::middleware(['auth', 'verified', 'approved'])->group(function() {
    Route::get('/', [PagesController::class, 'homepage'])->name('homepage');
    Route::get('/s', SearchController::class)->name('search');
    Route::get('/cookie-policy', function() {
        return view('cookie');
    })->name('cookie-policy');

    Route::post('/upload', [UploadController::class, 'store'])->name('upload');

    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/user/profile/settings/account', [ProfileController::class, 'accountSettings'])->name('profile.settings.account');
    Route::patch('/user/profile/settings/account', [ProfileController::class, 'update']);
    Route::post('/user/profile/settings/account/password', [ProfileController::class, 'password'])->name('profile.settings.password');
    Route::get('/user/profile/settings/security', [ProfileController::class, 'securitySettings'])->name('profile.settings.security');

    Route::redirect('/meals/{meal}', '/recipes/{meal}', 301);
    Route::redirect('/meals/', '/recipes/', 301);
    Route::get('recipes/liked', [RecipeController::class, 'liked'])->name('recipes.liked');
    Route::get('recipes/{recipe}/like', [RecipeController::class, 'like'])->name('recipes.like');
    Route::get('recipes/{recipe}/unlike', [RecipeController::class, 'unlike'])->name('recipes.unlike');
    Route::resource('recipes', RecipeController::class);
    Route::resource('menus', MenuController::class)->only(['index', 'create', 'store']);

    Route::prefix('admin')->name('admin.')->group(function()   {
        Route::get('/', [PagesController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class)->only(['index', 'show']);
        Route::resource('ingredients', IngredientController::class);
        Route::resource('allergens', AllergenController::class)->except('show');
        Route::get('/users/approve/{email}', [UserController::class, 'approve'])->name('users.approve');
        Route::resource('users', UserController::class)->except('show');
    });

});

Route::post('deploy', WebhookController::class);