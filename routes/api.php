<?php



use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user', [AuthController::class, 'register']);

use App\Http\Controllers\UserController;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', UserController::class);
    
});

