<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StatsController;

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

use App\Http\Controllers\Api\TodoController;

Route::prefix('todos')->middleware('throttle:60,1')->controller(TodoController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::post('/', 'store');
    Route::put('{id}', 'update');
    Route::patch('{id}/status', 'updateStatus');
    Route::delete('{id}', 'destroy');
    Route::get('/search', 'search');
});


Route::prefix('categories')->middleware('throttle:60,1')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::post('/', 'store');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'destroy');
    Route::get('{id}/todos', 'todos');
});


Route::prefix('stats')->middleware('throttle:60,1')->controller(StatsController::class)->group(function () {
    Route::get('/todos', 'todoStatusCounts');         // GET /api/stats/todos
    Route::get('/priorities', 'todoPriorityCounts');  // GET /api/stats/priorities
});

