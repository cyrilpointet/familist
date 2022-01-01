<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/profile', [UserController::class, 'show']);
    Route::post('/user/find', [UserController::class, 'findByEmail']);
    Route::post('/user/logout', [UserController::class, 'logout']);

    Route::post('/todolist', [TodolistController::class, 'create']);
});

Route::middleware(['auth:sanctum', 'isListMember'])->group(function () {
    Route::get('/todolist/{id}', [TodolistController::class, 'read']);
    Route::delete('/todolist/{id}', [TodolistController::class, 'delete']);
    Route::post('/todolist/{id}/user', [TodolistController::class, 'addMember']);
    Route::delete('/todolist/{id}/user', [TodolistController::class, 'removeMember']);

    Route::post('/todolist/{id}/product', [ProductController::class, 'create']);
    Route::delete('/todolist/{id}/product', [ProductController::class, 'delete']);

    Route::post('/todolist/{id}/invitation', [TodolistController::class, 'addInvitation']);
});
