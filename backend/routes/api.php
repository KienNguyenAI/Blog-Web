<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/user/{id}', [UserController::class, 'show']);
Route::get('/users', [AuthController::class, 'getAllUsers']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/resetPass', [AuthController::class, 'resetPass']);
