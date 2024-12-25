<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SavePostController;
use App\Http\Controllers\UserBioController;
use App\Http\Controllers\CommentController;


Route::get('/users', [UserController::class, 'getAllUsers']);
Route::post('/user/{userId}/update-avatar', [UserController::class, 'updateAvatar']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/user/{username}', [UserController::class, 'getUserByUsername']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/resetPass', [AuthController::class, 'resetPass']);

Route::post('/checkFollow', [FollowController::class, 'checkFollow']);
Route::post('/follow', [FollowController::class, 'follow']);
Route::post('/unfollow', [FollowController::class, 'unfollow']);
Route::post('/getFollowedAuthors', [FollowController::class, 'getFollowedAuthors']);

Route::put('/posts/{id}', [PostController::class, 'updatePost']);
Route::put('/postSlug/{slug}', [PostController::class, 'update']);
Route::get('/getAllPost', [PostController::class, 'getPost']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{slug}', [PostController::class, 'showBySlug']);
Route::get('/showPosts', [PostController::class, 'index']);
Route::delete('/delete/{slug}', [PostController::class, 'destroy']);
Route::get('/topPosts', [PostController::class, 'topVotedPosts']);
Route::get('/posts/tag/{tagSlug}', [PostController::class, 'topVotedPostsByTag']);
Route::get('/getPosts/{sort}', [PostController::class, 'getAllPosts']);
Route::get('/posts/user/{username}', [PostController::class, 'getPostsByUsername']);
Route::get('/post/{slug}/{userId}', [PostController::class, 'getPostDetails']);

// Comment
Route::get('/comments', [CommentController::class, 'index']); // Lấy tất cả bình luận của bài viết
Route::post('/comments', [CommentController::class, 'store']);


Route::post('/uploadAvatar', [FileUploadController::class, 'uploadAvatar'])->name('upload');
Route::post('/upload', [FileUploadController::class, 'upload'])->name('upload');
Route::post('/delete-image', [FileUploadController::class, 'deleteImage']);

Route::post('/votes', [VoteController::class, 'store']); // Thêm hoặc cập nhật vote
Route::get('/votes/{postId}', [VoteController::class, 'getVotes']);
Route::get('/user/{userId}/upvotes', [VoteController::class, 'getUserUpvotes']);


Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{id}', [TagController::class, 'show']);
Route::get('/tag/{slug}', [TagController::class, 'showBySlug']);
Route::post('/add', [TagController::class, 'store']);
Route::delete('/tags/slug/{slug}', [TagController::class, 'destroyBySlug']);

Route::post('/savePost', [SavePostController::class, 'store']);

Route::get('userBio/{userId}', [UserBioController::class, 'getUserBioByUserId']);
Route::put('saveUserBio/{userId}', [UserBioController::class, 'storeUserBio']);
