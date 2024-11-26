<?php
// Dependencies
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;

// User
Route::post('register', [LoginController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('user', UserController::class)->middleware('auth:sanctum');

// Posts
Route::get('post', [PostController::class, 'index']);
Route::post('post', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::get('post/{id}', [PostController::class, 'show']);
Route::put('post/{id}', [PostController::class, 'update'])->middleware('auth:sanctum');
Route::delete('post/{id}', [PostController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('post/search/{query}', [PostController::class, 'search']);
Route::get('post/filter/{id}', [PostController::class, 'filter']);

// Comments
Route::get('post/{id}/comment', [CommentController::class, 'index']);
Route::post('post/{id}/comment', [CommentController::class, 'store'])->middleware('auth:sanctum');
Route::put('comment/{id}', [CommentController::class, 'update'])->middleware('auth:sanctum');
Route::delete('comment/{id}', [CommentController::class, 'destroy'])->middleware('auth:sanctum');

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');