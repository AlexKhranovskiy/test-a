<?php

use App\Http\Controllers\AuthController;
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
Route::get('/v1/token', [AuthController::class, 'getToken']);
Route::get('/v1/users', [UserController::class, 'getAll']); //->middleware('auth.jwt');
Route::post('/v1/users', [UserController::class, 'register']);
Route::get('/v1/users/{id}', [UserController::class, 'getById']); //->whereNumber('id');

//Route::group(['middleware' => ['auth.jwt']], function () {
//    Route::prefix('v1')->group(
//        function () {
//            Route::get('/token', [AuthController::class, 'getToken']);
//            Route::get('/users', [AuthController::class, 'getAll']);
//        });
//});
