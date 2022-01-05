<?php

use App\Http\Controllers\JWTController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function($router){

    Route::post('/user/register', [JWTController::class, 'register']);
    Route::post('/user/login', [JWTController::class, 'login']);
    Route::post('/user/logout', [JWTController::class, 'logout']);
    Route::post('/user/profile', [JWTController::class, 'profile']);
    Route::post('/user/refresh', [JWTController::class, 'refresh']);
    Route::post('/user/contact', [JWTController::class, 'contact']);
    // Route::apiResource('tasks', ApiController::class);

});