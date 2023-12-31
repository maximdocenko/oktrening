<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

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

Route::post('products/filter', [ProductController::class, 'filter']);
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);

Route::get('add-to-cart/{id}', [\App\Http\Controllers\CartController::class, 'addToCart']);
Route::patch('update-cart', [\App\Http\Controllers\CartController::class, 'update']);
Route::delete('remove-from-cart', [\App\Http\Controllers\CartController::class, 'remove']);

