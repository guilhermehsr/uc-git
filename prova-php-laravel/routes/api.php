<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//post
Route::post('post', [PostController::class,'make']);
Route::get('post', [PostController::class, 'list']);
Route::delete('post/{id}', [PostController::class, 'delete']);
Route::put('post/{id}', [PostController::class, 'edit']);
Route::get('post/{id}', [PostController::class, 'show']);

//comment
Route::post('post/{id}/comment', [CommentController::class,'make']);
Route::get('post/{id}/comment', [CommentController::class, 'list']);
Route::delete('post/{id}/comment/{id_c}', [CommentController::class, 'delete']);
Route::put('post/{id}/comment/{id_c}', [CommentController::class, 'edit']);
Route::get('post/{id}/comment/{id_c}', [CommentController::class, 'show']);

