<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SubscriptionTypeController;

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


Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('{id}/subscription', [SubscriptionController::class, 'create']);
    Route::put('{userId}/subscription/{subscriptionId}', [SubscriptionController::class, 'update']);
    Route::delete('{id}/subscription', [SubscriptionController::class, 'delete']);
    Route::post('{id}/transaction', [TransactionController::class, 'create']);
    Route::get('{id}', [UserController::class, 'get']);
});

Route::resource('subscription-types', SubscriptionTypeController::class);


