<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\AuthController;
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

//Route::get('order/{id}', [OrderTestController::class, 'show']);
//Route::get('order', [OrderTestController::class, 'index']);

//

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('products', [ProductController::class, 'index']);
Route::get('suppliers', [SupplierController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('suppliers', SupplierController::class)->only(['show', 'store','destroy']);
    Route::resource('products', ProductController::class)->only(['show', 'store','destroy']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('orders', OrderController::class);
    Route::put('orders/{id}/edit', [OrderController::class, 'update']);
    Route::put('suppliers/{id}/edit', [SupplierController::class, 'update']);
    Route::put('products/{id}/edit', [ProductController::class, 'update']);

});