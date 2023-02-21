<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


///users routes
Route::group(['prefix' => '/users'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

/// todos routes
Route::group(['prefix' => '/todos'], function () {
    Route::get('/list', [TodoController::class, 'index']);
    Route::get('/list/{id}', [TodoController::class, 'show']);
    Route::post('/create', [TodoController::class, 'store']);
    Route::put('/update/{id}', [TodoController::class, 'update']);
    Route::delete('/delete/{id}', [TodoController::class, 'destroy']);
    Route::post('/trashed', [TodoController::class, 'trashedTodos']);
    Route::post('/restore/{id}', [TodoController::class, 'restoreTrashedTodo']);
    Route::post('/forceDelete/{id}', [TodoController::class, 'forceDeleteTrashedTodo']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
