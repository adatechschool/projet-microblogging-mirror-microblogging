<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

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

// Default route to get authenticated user details
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for PostController
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('posts.comments', CommentController::class)->shallow();
    Route::post('posts/{post}/like', [LikeController::class, 'likePost'])->name('posts.like');
    Route::delete('posts/{post}/unlike', [LikeController::class, 'unlikePost'])->name('posts.unlike');
});

// Additional routes for LikeController (if needed for comments)
Route::post('comments/{comment}/like', [LikeController::class, 'likeComment'])->name('comments.like');
Route::delete('comments/{comment}/unlike', [LikeController::class, 'unlikeComment'])->name('comments.unlike');
