<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Product\ProductController;
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
Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('auth-user', [AuthController::class, 'authUser']);
        Route::get('logout', [AuthController::class, 'logout']);

        // Product
        Route::apiResource('products', ProductController::class);

        // Cart
        Route::get('cart-items', [CartController::class, 'cartItems']);
        Route::post('add-to-cart', [CartController::class, 'addToCart']);
        Route::post('cart-item-quantity-set/{cartItemIndex}', [CartController::class, 'cartItemQuantitySet']);
        Route::post('increment-cart-item/{cartItemIndex}', [CartController::class, 'incrementCartItem']);
        Route::post('decrement-cart-item/{cartItemIndex}', [CartController::class, 'decrementCartItem']);
        Route::delete('remove-from-cart/{cartItemIndex}', [CartController::class, 'removeFromCart']);
        Route::delete('clear-cart', [CartController::class, 'clearCart']);
    });
});
