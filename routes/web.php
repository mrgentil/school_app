<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentHistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes(['register' => false]);
Auth::routes(['reset' => true]);
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    //Home Route
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //User  ROutes
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');


    //Role Routes
    Route::resource('roles', \App\Http\Controllers\RoleController::class);

    //School Routes
    Route::resource('schools', \App\Http\Controllers\SchoolController::class);
    Route::get('/schools/search', [SchoolController::class, 'search'])->name('schools.search');

    //Student Routes
    Route::resource('students', \App\Http\Controllers\StudentController::class);

    //Class Routes
    Route::resource('classes', \App\Http\Controllers\ClasseController::class);

    //Option Routes
    Route::resource('options', \App\Http\Controllers\OptionController::class);

    //Promotion Routes
    Route::resource('promotions', \App\Http\Controllers\PromotionController::class);

    // Routes pour l'historique
    Route::get('histories', [StudentHistoryController::class, 'index'])
        ->name('histories.index');
    Route::get('histories/create', [StudentHistoryController::class, 'create'])
        ->name('histories.create');
    Route::post('histories', [StudentHistoryController::class, 'store'])
        ->name('histories.store');
    Route::get('histories/{history}/edit', [StudentHistoryController::class, 'edit'])
        ->name('histories.edit');
    Route::put('histories/{history}', [StudentHistoryController::class, 'update'])
        ->name('histories.update');
    Route::delete('histories/{history}', [StudentHistoryController::class, 'destroy'])
        ->name('histories.destroy');
    Route::get('histories/{history}', [StudentHistoryController::class, 'show'])  // Ajout de la route show
    ->name('histories.show');
});


