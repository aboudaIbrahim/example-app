<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


///users routes
Route::group(['prefix' => '/users'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('users.register');
    Route::post('/login', [AuthController::class, 'login'])->name('users.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('users.logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('users.refresh');
});

/// todos routes
Route::group(['prefix' => '/todos'], function () {
    Route::get('/list', [TodoController::class, 'index'])->name('todos.index');
    Route::get('/list/{id}', [TodoController::class, 'show'])->name('todos.show');
    Route::post('/create', [TodoController::class, 'store'])->name('todos.store');
    Route::put('/update/{id}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/delete/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::post('/trashed', [TodoController::class, 'displayTrashedTodos'])->name('todos.displayTrashedTodos');
    Route::post('/restore/{id}', [TodoController::class, 'restoreTrashedTodo'])->name('todos.restoreTrashedTodo');
    Route::post('/forceDelete/{id}', [TodoController::class, 'forceDeleteTrashedTodo'])->name('todos.forceDeleteTrashedTodo');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
