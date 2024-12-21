<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Models\Product;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('product',[ProductController::class,'index']);

Route::get('product/{id}', [ProductController::class, 'getProductById']);

Route::post('cart', [CartItemController::class, 'store']);

Route::post('send-otp', [SmsController::class, 'sendsms']);

Route::post('verify-otp', [SmsController::class, 'verifyOtp']);

Route::post('users', [UserController::class, 'store']);


