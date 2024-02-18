<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [AuthController::class, 'auth'])->name('login');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

//House routes
Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');
Route::post('/houses', [HouseController::class, 'store'])->name('houses.store');
Route::get('/houses/{house}', [HouseController::class, 'show'])->name('houses.show');
Route::put('/houses/{house}', [HouseController::class, 'update'])->name('houses.update');
Route::delete('/houses/{house}', [HouseController::class, 'destroy'])->name('houses.destroy');


//To prevent duplicating blank routes for vue.js, we can use this wildcard route
Route::get('/{any?}', function () {
    return view('layouts.main');
});
