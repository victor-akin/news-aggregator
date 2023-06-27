<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::post('auth/register', [AuthController::class, 'register'])->name('register');

Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');
