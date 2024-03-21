<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

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

Route::group(['middleware' => ['web']], function () {
    Route::get('indexPage', [TodoController::class, 'indexPage']);
    Route::get('projectIndexPage', [ProjectController::class, 'indexPage']);
    Route::get('completed', [TodoController::class, 'completed']);
    Route::get('todaytask', [TodoController::class, 'getTodayTask']);
    Route::get('inprocess', [TodoController::class, 'inProcess']);
    Route::get('index', [TodoController::class, 'index'])->name('index');
    Route::delete('delete/{id}', [TodoController::class, 'destroy'])->name('destroy');
    Route::get('create', [TodoController::class, 'create']);
    Route::post('store', [TodoController::class, 'store']);
    Route::patch('update', [TodoController::class, 'update']);
    Route::get('search', [TodoController::class, 'search']);
    Route::get('projects', [ProjectController::class, 'index']);
    Route::post('project', [ProjectController::class, 'store']);
    Route::get('login', [TodoController::class, 'loginPage']);
    Route::post('login', [TodoController::class, 'login']);
    Route::post('logout', [TodoController::class, 'logout']);
    Route::get('register', [TodoController::class, 'registerPage']);
    Route::post('register', [TodoController::class, 'register']);
});


