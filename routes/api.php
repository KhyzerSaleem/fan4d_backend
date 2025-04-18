<?php

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\AddressesController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\HelpersController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CouponsController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\PointsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('client')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::post('/direct-order', [HomeController::class, 'directOrder']);

        Route::prefix('auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);

            Route::post('/sign_up', [AuthController::class, 'signUp']);
            Route::post('/sign_up/verify', [AuthController::class, 'verifySignUp']);

            Route::post('/forget_password', [AuthController::class, 'forgetPassword']);
            Route::post('/forget_password/verify', [AuthController::class, 'verifyForgetPassword']);
            Route::post('/forget_password/update_password', [AuthController::class, 'ForgetPasswordUpdatePassword']);
        });

        Route::group(['prefix' => "helpers"], function () {
            Route::get('/splashes', [HelpersController::class, 'splashes']);
            Route::get('/cities', [HelpersController::class, 'cities']);
            Route::get('/areas/{id}', [HelpersController::class, 'areas']);
        });


        Route::group(['prefix' => "app"], function () {
            Route::get('pages/{type}', [SettingsController::class, 'pages']);
            Route::get('/settings', [SettingsController::class, 'settings']);
            Route::get('/settings/{key}', [SettingsController::class, 'custom_settings']);
            Route::post('/contact-us', [SettingsController::class, 'contactUs']);
        });

//        home Apis
        Route::group(['prefix' => "home"], function () {
            Route::get('/articles', [HomeController::class, 'articles']);
            Route::get('/categories', [HomeController::class, 'categories']);
            Route::get('/sliders', [HomeController::class, 'sliders']);
            Route::get('/banners', [HomeController::class, 'banners']);
            Route::get('/about', [HomeController::class, 'about']);
            Route::get('/steps', [HomeController::class, 'steps']);
            Route::get('/reviews', [HomeController::class, 'reviews']);
            Route::get('/offers', [HomeController::class, 'offers']);
            Route::get('/not-print-products', [HomeController::class, 'notPrintProducts']);
        });

        Route::get('/offers', [HomeController::class, 'allOffers']);


        Route::get('/categories', [HomeController::class, 'allCategories']);
        Route::get('/categories/{type}', [HomeController::class, 'categoriesByType']);


        Route::group(['prefix' => "products"], function () {
            Route::get('/', [ProductsController::class, 'index']);
            Route::post('/calculate/price', [ProductsController::class, 'calculatePrice']);
            Route::get('/{id}', [ProductsController::class, 'show']);
            Route::get('/categories/list', [ProductsController::class, 'categories']);
        });

    });


    Route::group(['middleware' => ['user']], function () {

        Route::post('/get-price', [HomeController::class, 'getPrice']);

        Route::prefix('auth')->group(function () {
            Route::get('/delete-account', [AuthController::class, 'deleteAccount']);

//            Route::post('/change-password', [AuthController::class, 'changePassword'])->name('client.change.password');
            Route::get('/logout', [AuthController::class, 'logout'])->name('client.logout');

            Route::prefix('profile')->group(function () {
                Route::get('/', [AuthController::class, 'profile']);
                Route::post('/update', [AuthController::class, 'profileUpdate']);
                Route::post('/update/physical_data', [AuthController::class, 'updatePhysicalData']);
            });
            Route::get('/price_requests', [AuthController::class, 'priceRequests']);
            Route::get('/price_request/details/{get_price}', [AuthController::class, 'priceRequestDetails']);

        });

        Route::prefix('wishlist')->group(function () {
            Route::post('/add', [AuthController::class, 'addWishlist']);
            Route::get('/get', [AuthController::class, 'getWishlist']);
        });
        Route::group(['prefix' => "points"], function () {
            Route::get('/transactions', [PointsController::class, 'transactions']);
            Route::get('/change', [PointsController::class, 'change']);

        });
        //        addresses
        Route::group(['prefix' => "addresses"], function () {
            //addresses
            Route::get('/', [AddressesController::class, 'index']);
            Route::get('/details', [AddressesController::class, 'details']);
            Route::post('/store', [AddressesController::class, 'store']);
            Route::post('/update', [AddressesController::class, 'update'])->name('addresses.update');
            Route::post('/make-default', [AddressesController::class, 'makeDefault']);
            Route::post('/delete', [AddressesController::class, 'delete']);
        });

        Route::group(['prefix' => "orders"], function () {
            Route::get('/', [OrdersController::class, 'index']);
            Route::post('/apply/voucher', [OrdersController::class, 'applyVoucher']);
            Route::post('/place', [OrdersController::class, 'place']);
            Route::get('/details', [OrdersController::class, 'details']);
            Route::post('/cancel', [OrdersController::class, 'cancelOrder']);

            Route::get('/details', [OrdersController::class, 'details']);
            Route::post('/rate', [OrdersController::class, 'rate']);
            Route::post('/complain', [OrdersController::class, 'complain']);
            Route::post('/execute/pay', [OrdersController::class, 'executePay']);
            Route::post('/cancel', [OrdersController::class, 'cancelOrder']);
        });

        Route::group(['prefix' => "cart"], function () {
            Route::get('/', [CartController::class, 'index']);
            Route::post('/add', [CartController::class, 'addCart']);
            Route::post('/remove', [CartController::class, 'removeCart']);

        });
        Route::group(['prefix' => "notifications"], function () {
            Route::get('/', [NotificationController::class, 'index']);
        });

        Route::group(['prefix' => "coupons"], function () {
            Route::get('/', [CouponsController::class, 'index']);
        });
    });

});


