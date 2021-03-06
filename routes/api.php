<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirectMessageController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocketController;
use App\Http\Controllers\UserController;

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

Route::post('/user', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/user', UserController::class, ['except' => 'store']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/direct-message', DirectMessageController::class);
    Route::apiResource('/message', MessageController::class);
});

Route::get('/socket', [SocketController::class, 'test']);
