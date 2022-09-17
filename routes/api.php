<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Merchants;
use App\Http\Controllers\Api;


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

Route::post('/merchants/auth/register', [Merchants\MerchantAuthController::class, 'createUser']);
Route::post('/merchants/auth/login', [Merchants\MerchantAuthController::class, 'loginUser']);
Route::post('/auth/register', [Api\AuthController::class, 'createUser']);
Route::post('/auth/login', [Api\AuthController::class, 'loginUser']);

Route::group(['middleware' => ['auth:sanctum', 'abilities:Merchant']], function () {
    Route::put('/merchants/stores', [Merchants\StoreController::class, 'update']);
    Route::resource('/merchants/stores', Merchants\StoreController::class);
    Route::resource('/merchants/products', Merchants\ProductController::class);
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:User']], function () {
    Route::post('/cart/add-product', [Api\CartController::class, 'add_product']);
    Route::get('/my-cart', [Api\CartController::class, 'my_cart']);
});

Route::get('/products', [Api\ProductController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
