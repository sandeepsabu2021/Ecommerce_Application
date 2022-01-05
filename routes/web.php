<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\IsLogin;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsInvManager;
use App\Http\Middleware\IsOrdManager;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware([IsLogin::class])->group(function () {
    Route::get('/test', function () {
        return "Session - User logged in";
    });

    Route::get('/master', [AdminController::class, 'master']);
    Route::get('/home', [AdminController::class, 'home']);
    Route::get('/change-password', [AdminController::class, 'changePass']);
    Route::post('/changepassvalid', [AdminController::class, 'passValid']);
    Route::get('/edit-profile', [AdminController::class, 'editProfile']);
    Route::post('/editprofilevalid', [AdminController::class, 'editProfileValid']);

    Route::middleware([IsAdmin::class])->group(function () {
        Route::get('/admin', function () {
            return "Session - Admin";
        });

        Route::get('/user', [AdminController::class, 'user']);
        Route::get('/add-user', [AdminController::class, 'addUser']);
        Route::post('/uservalid', [AdminController::class, 'userValid']);
        Route::get('/modify-user-{id}', [AdminController::class, 'modifyUser']);
        Route::post('/modifyuservalid', [AdminController::class, 'modifyUserValid']);
        Route::delete('/deleteuser', [AdminController::class, 'delUser']);

        Route::get('/banner', [BannerController::class, 'banner']);
        Route::get('/add-banner', [BannerController::class, 'addBanner']);
        Route::post('/bannervalid', [BannerController::class, 'bannerValid']);
        Route::get('/edit-banner-{id}', [BannerController::class, 'editBanner']);
        Route::post('/editbannervalid', [BannerController::class, 'editBannerValid']);
        Route::delete('/deletebanner', [BannerController::class, 'delBanner']);

        Route::get('/contact', [ContactController::class, 'contact']);
    });

    Route::middleware([IsInvManager::class])->group(function () {
        Route::get('/inventory', function () {
            return "Session - Permission available";
        });

        Route::get('/category', [CategoryController::class, 'category']);
        Route::get('/add-category', [CategoryController::class, 'addCategory']);
        Route::post('/categoryvalid', [CategoryController::class, 'categoryValid']);
        Route::get('/edit-category-{id}', [CategoryController::class, 'editCategory']);
        Route::post('/editcategoryvalid', [CategoryController::class, 'editCatValid']);
        Route::delete('/deletecat', [CategoryController::class, 'delCategory']);

        Route::get('/product{id?}', [ProductController::class, 'product']);
        Route::get('/add-product', [ProductController::class, 'addProduct']);
        Route::post('/productvalid', [ProductController::class, 'productValid']);
        Route::get('/edit-product-{id}', [ProductController::class, 'editProduct']);
        Route::get('view-product-{id}', [ProductController::class, 'viewProduct']);
        Route::delete('/deleteimage', [ProductController::class, 'delImage']);
        Route::post('/editproductvalid', [ProductController::class, 'editProValid']);
        Route::delete('/deleteproduct', [ProductController::class, 'delProduct']);
    });

    Route::middleware([IsOrdManager::class])->group(function () {
        Route::get('/ordmanage', function () {
            return "Session - Permission available";
        });

        Route::get('/order', [OrderController::class, 'order']);

    });

    Route::get('/logout', [AdminController::class, 'logout']);
});
