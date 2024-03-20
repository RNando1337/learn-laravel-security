<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->prefix('/users')->group(function(){
    Route::get('/login', 'login');
    Route::get('/logout', 'logout');
    Route::get('/me', 'me');
    Route::post('/register', 'register');
    Route::post('/refresh', 'refresh');
});