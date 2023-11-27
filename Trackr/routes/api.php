<?php

use App\Http\Controllers\Api\ApiPackagesController;
use App\Http\Controllers\Api\ApiUsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiLoginController;
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

Route::post('/login', [ApiLoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [ApiLoginController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/users', [ApiUsersController::class, 'allUsers']);
Route::middleware('auth:sanctum')->post('/packages/update-status/{packageId}', [ApiPackagesController::class, 'changePackageStatus']);
Route::middleware('auth:sanctum')->post('/packages/create', [ApiPackagesController::class, 'registerPackage']);
