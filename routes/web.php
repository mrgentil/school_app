<?php

use App\Http\Controllers\AdminController;
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
    Route::resource('users', \App\Http\Controllers\UserController::class);

    //Role Routes
    Route::resource('roles', \App\Http\Controllers\RoleController::class);

    //School Routes
    Route::resource('schools', \App\Http\Controllers\SchoolController::class);
});


