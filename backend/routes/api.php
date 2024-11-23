<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\VoteController;


Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/user/{username}', [UserController::class, 'getUserByUsername']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/resetPass', [AuthController::class, 'resetPass']);

Route::post('/follow', [FollowController::class, 'follow']);
Route::post('/checkFollow', [FollowController::class, 'checkFollow']);
Route::post('/unfollow', [FollowController::class, 'unfollow']);

Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{id}', [PostController::class, 'show']);

Route::post('/upload', [FileUploadController::class, 'upload'])->name('upload');
Route::post('/delete-image', [FileUploadController::class, 'deleteImage']);

Route::post('/votes', [VoteController::class, 'store']); // Thêm hoặc cập nhật vote
Route::get('/votes/{postId}', [VoteController::class, 'getVotes']);
