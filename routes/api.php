<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckApiToken;
use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\BannerApiController;
use App\Http\Controllers\Api\OrderApiController;

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

Route::group(
    [
        'namespace' => 'Controllers',
        'prefix' => 'v1',
    ],
    function () {
        Route::middleware([CheckApiToken::class])->group(function () {
            Route::post('/me', [AuthApiController::class, 'me']);
            Route::post('/change-password', [AuthApiController::class, 'changePassword']);
            Route::post('/delete-account', [AuthApiController::class, 'deleteAccount']);

            //Order
            Route::get('/orders',[OrderApiController::class, 'orderList']);
            Route::post('/order/store',[OrderApiController::class, 'storeOrder']);
            Route::get('/order/detail',[OrderApiController::class, 'orderDetail']);

            Route::get('/notifications',[AuthApiController::class, 'notiList']);
            Route::get('/count-noti',[AuthApiController::class, 'countUnreadNoti']);
            Route::post('/update-noti', [AuthApiController::class, 'updateNoti']);

            Route::get('/payment-methods',[AuthApiController::class, 'paymentMethodList']);

            Route::post('/update-profile', [AuthApiController::class, 'updateProfile']);
            Route::post('/upload-profile-image', [AuthApiController::class, 'uploadProfileImage']);
        });
        
        Route::get('/brands',[BrandApiController::class, 'brandList']);
        Route::get('/banners',[BannerApiController::class, 'bannerList']);
        Route::get('/products',[ProductApiController::class, 'productList']);
        Route::post('/products/search',[ProductApiController::class, 'search']);
        Route::get('/categories',[CategoryApiController::class, 'categoryList']);
        Route::post('/register', [AuthApiController::class, 'register']);
        Route::post('/login', [AuthApiController::class, 'login']);
        Route::get('/countries',[AuthApiController::class, 'getCountry']);
        Route::get('/states',[AuthApiController::class, 'getState']);
        Route::get('/townships',[AuthApiController::class, 'getTownship']);
        Route::get('/delivery-times',[AuthApiController::class, 'getDeliveryTime']);
        Route::post('/set-fcm-token',[AuthApiController::class, 'setFcmToken']);
        Route::get('/check-version',[AuthApiController::class, 'checkVersion']);
    }
);