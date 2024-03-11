<?php

use App\Http\Controllers\TodoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['web']], function () {
    Route::get('index', [TodoController::class, 'index'])->name('index')->middleware(['web']);
    Route::delete('delete/{id}', [TodoController::class, 'destroy'])->name('destroy');
    Route::get('create', [TodoController::class, 'create']);
    Route::post('store', [TodoController::class, 'store']);
    Route::patch('update', [TodoController::class, 'update']);

    Route::get('login', [TodoController::class, 'loginPage']);
    Route::post('login', [TodoController::class, 'login']);
    Route::get('register', [TodoController::class, 'registerPage']);

    Route::post('register', [TodoController::class, 'register']);
});


