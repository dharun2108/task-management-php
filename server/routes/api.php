<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);


Route::middleware('auth:sanctum')->prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'save']);
    Route::put('/{task}', [TaskController::class, 'update']);
    Route::post('/fetch', [TaskController::class, 'index']);
    Route::delete('/{id}', [TaskController::class, 'delete']);
    Route::put('/toggle/{id}', [TaskController::class, 'toggleTask']);
});