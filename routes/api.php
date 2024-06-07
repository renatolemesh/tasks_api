<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoItemController;
use App\Http\Controllers\TodoItemTagController;
use App\Http\Controllers\TagController;
use App\Http\Middleware\AdminMiddleware;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::apiResource('tags', TagController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('todo', TodoController::class);
    Route::apiResource('/todos/{todo}/items', TodoItemController::class);

    Route::get('/items/{item}/tags', [TodoItemTagController::class, 'index']);
    Route::post('/items/{item}/tags', [TodoItemTagController::class, 'store']);
    Route::delete('/items/{item}/tags', [TodoItemTagController::class, 'destroy']);

    Route::put('/users/{user}', [AuthController::class, 'update']);
    Route::delete('/users/{user}', [AuthController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'show']);
    
});
