<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) { return $request->user(); });

    Route::post('/user/profile/interests', [UserController::class, 'addInterest']);

    Route::delete('/user/profile/interests/{id}', [UserController::class, 'removeInterest']);

    Route::get('/user/profile/interests', [UserController::class, 'getUserInterests']);

    Route::get('/user/profile/news-feed', [UserController::class, 'getUserNewsFeed']);

    Route::get('/search', [NewsController::class, 'search']);

    Route::get('/article', [NewsController::class, 'getArticle']);
});


Route::get('category', [NewsController::class, 'getCategories']);

Route::get('news/latest', [NewsController::class, 'getLatestNews']);
