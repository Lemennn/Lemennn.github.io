<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\ProductGalleryController;
use App\Http\Controllers\API\ProductCategoryController;

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
Route::get('products', [ProductController::class, 'fetch']);
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::get('productcategories', [ProductCategoryController::class, 'fetch']);
Route::get('productgalleries', [ProductGalleryController::class, 'fetch']);
Route::post('payment', [PaymentController::class, 'payment_handler']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('transactions', [TransactionController::class, 'fetch']);
    Route::post('checkout' , [TransactionController::class, 'checkout']);
    Route::post('feedbacksend', [FeedbackController::class, 'sendfeedback']);
    Route::get('feedback', [FeedbackController::class, 'fetch']);

    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);
});
