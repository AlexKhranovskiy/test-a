<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(
    function () {
        Route::get('/token', [AuthController::class, 'getToken'])->name('token');
        Route::get('/users', [UserController::class, 'getAll'])->name('users.all');
        Route::get('/users/{id}', [UserController::class, 'getById'])->name('users.show');
        Route::post('/users', [UserController::class, 'register'])->name('users.register')
            ->middleware('auth.jwt');
        Route::get('/positions', [PositionController::class, 'getAll'])->name('positions');
    });
