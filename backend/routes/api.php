<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// User Create and Auth
Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);


// Email Verification
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('/email/verify', [EmailVerifyController::class, 'notice'])->name('verification.notice');
    Route::get('/email/resend-verification-notification', [EmailVerifyController::class, 'resend'])->name('verification.send');
});

Route::get('/email/verify/{id}', [EmailVerifyController::class, 'verify'])->name('verification.verify');


// Store
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('stores', [StoreController::class, 'listStores']);
    Route::get('stores/my-stores', [StoreController::class, 'listUserStores']);
    Route::post('stores', [StoreController::class, 'store']);
    Route::put('stores/{store}', [StoreController::class, 'update']);
    Route::delete('stores/{store}', [StoreController::class, 'destroy']);
});
