<?php

use App\Http\Controllers\JWTController;
use App\Http\Controllers\VueApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function($router){

    Route::post('/user/register', [JWTController::class, 'register']);
    Route::post('/user/login', [JWTController::class, 'login']);
    Route::post('/user/changepass', [JWTController::class, 'changepass']);
    Route::post('/user/logout', [JWTController::class, 'logout']);
    Route::post('/user/profile', [JWTController::class, 'profile']);
    Route::post('/user/refresh', [JWTController::class, 'refresh']);
    Route::post('/user/contact', [JWTController::class, 'contact']);
    Route::post('/user/editprofile', [JWTController::class, 'editprofile']);
    Route::post('/user/checkout', [JWTController::class, 'checkout']);

});

Route::get('/shop/{id?}', [VueApiController::class, 'showProduct']);
Route::get('/shop/product/{id}', [VueApiController::class, 'product']);
Route::get('/category', [VueApiController::class, 'category']);
Route::get('/brand', [VueApiController::class, 'brand']);
Route::get('/banner', [VueApiController::class, 'banner']);
Route::get('/feature', [VueApiController::class, 'feature']);
Route::get('/recommend', [VueApiController::class, 'recommend']);
Route::get('/cms/{id?}', [VueApiController::class, 'cms']);
Route::get('/profile/{id}', [VueApiController::class, 'profile']);
Route::get('/coupon/{id}', [VueApiController::class, 'coupon']);
Route::get('/order/{id}', [VueApiController::class, 'order']);