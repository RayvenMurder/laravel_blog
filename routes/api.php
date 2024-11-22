<?php
// Dependencies
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

// Routes
Route::apiResource('user', UserController::class);
Route::apiResource('post', PostController::class);
Route::apiResource('comment', CommentController::class);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');