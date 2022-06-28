<?php

use App\Http\Controllers\v1\OrdersController;
use App\Http\Controllers\v1\OrderSubscriptionsController;
use App\Http\Controllers\v1\PhoneNumbersController;
use Illuminate\Http\Request;
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


Route::apiResource('orders', OrdersController::class);
Route::apiResource('orders.subscriptions', OrderSubscriptionsController::class);
Route::apiResource('phoneNumbers', PhoneNumbersController::class);
