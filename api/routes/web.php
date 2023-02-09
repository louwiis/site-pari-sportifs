<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\UserBetController;
use App\Http\Controllers\BetController;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::get('users', [UserController::class, 'index']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('me', [UserController::class, 'me']);
    });
});


Route::group(['prefix' => 'user-bets'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/{id}', [UserBetController::class, 'store']);
    });
});

Route::group(['prefix' => 'matches'], function () {
    Route::get('/', [MatchController::class, 'index']);
    Route::get('/{id}', [MatchController::class, 'show']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/', [MatchController::class, 'store']);
        Route::post('/bet/{id}', [BetController::class, 'createBet']);
        Route::delete('/bet/{id}', [BetController::class, 'deleteBet']);
        Route::put('/bet/{id}', [BetController::class, 'updateStatusBetLine']);
    });
});

Route::group(['prefix' => 'leagues'], function () {
    Route::get('/', [LeagueController::class, 'index']);
    Route::post('/', [LeagueController::class, 'store']);
});
