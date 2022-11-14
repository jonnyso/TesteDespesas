<?php

use App\Http\Controllers\Auth\BearerTokenController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sanctum/token', [BearerTokenController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/sanctum/token', [BearerTokenController::class, 'destroy']);

    Route::apiResource('users', UsersController::class);
    Route::apiResource('expenses', ExpensesController::class);
});
