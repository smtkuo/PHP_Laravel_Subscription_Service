<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SubscriptionTypeController;
use App\Http\Controllers\AuthController;

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

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');



Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    // Protected routes go here
    Route::group(['prefix' => 'user'], function () {
        Route::post('/register', [UserController::class, 'register'])->name('api.user.register');
        Route::post('{id}/subscription', [SubscriptionController::class, 'create'])->name('api.user.subscription');
        Route::put('{userId}/subscription/{subscriptionId}', [SubscriptionController::class, 'update'])->name('api.user.login');
        Route::delete('{id}/subscription', [SubscriptionController::class, 'delete'])->name('api.user.login');
        Route::post('{id}/transaction', [TransactionController::class, 'create'])->name('api.user.login');
        Route::get('{id}', [UserController::class, 'get'])->name('api.user.login');
        
    });
});

Route::resource('subscription-types', SubscriptionTypeController::class);


