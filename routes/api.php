<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SendEmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/fake', [AuthController::class, 'registerFakeUser']);
Route::post('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/list', [SendEmailController::class, 'list'])->middleware('auth:sanctum');
Route::post('/send', [SendEmailController::class, 'sendEmail'])->middleware('auth:sanctum');



