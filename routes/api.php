<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Registration route
Route::post('register', [AuthApiController::class, 'register']);

// Login route
Route::post('login', [AuthApiController::class, 'login']);

// logout route
Route::post('logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('dashboard', [AuthApiController::class, 'dashboard']);