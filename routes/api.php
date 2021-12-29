<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/profile', [UserController::class, 'show']);
    Route::post('/user/find', [UserController::class, 'findByEmail']);
    Route::post('/user/logout', [UserController::class, 'logout']);
});