<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:api')-> group(function(){
    Route::get('/personas', [PersonController::class, 'index']);
    Route::get('/persona/{id}', [PersonController::class, 'show']);
    Route::post('/personas', [PersonController::class, 'store']);
    Route::delete('/persona/{id}', [PersonController::class, 'destroy']);
    Route::put('/persona/{id}', [PersonController::class, 'update']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);