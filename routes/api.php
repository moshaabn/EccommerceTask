<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Merchants\MerchantAuthController;
use App\Http\Controllers\Api\Merchants\StoreController;
use App\Http\Controllers\Api\Merchants\ProductController;


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

Route::post('/merchants/auth/register', [MerchantAuthController::class, 'createUser']);
Route::post('/merchants/auth/login', [MerchantAuthController::class, 'loginUser']);
// Route::post('/auth/register', [AuthController::class, 'createUser']);
// Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::group(['middleware' => ['auth:sanctum', 'abilities:Merchant']], function () {
    Route::put('/merchants/stores', [StoreController::class, 'update']);
    Route::resource('/merchants/stores', StoreController::class);
    Route::resource('/merchants/products', ProductController::class);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
