<?php

use App\Http\Controllers\ApiTodoController;
use App\Http\Controllers\AuthController;
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

Route::patch('serve/update', [ApiTodoController::class, 'update']);
Route::get('serve/createData', [ApiTodoController::class, 'createData']);
//
Route::get('serve/index', [ApiTodoController::class, 'index']);
//
Route::post('serve/store', [ApiTodoController::class, 'store']);
//
Route::delete('serve/delete', [ApiTodoController::class, 'destroy']);
//
Route::get('serve/completed', [ApiTodoController::class, 'completed']);
//
Route::get('serve/inprocess', [ApiTodoController::class, 'inProcess']);

Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login' );
    ROute::post('register','register');
    ROute::post('logout','logout');
    ROute::post('refresh','refresh');
});
