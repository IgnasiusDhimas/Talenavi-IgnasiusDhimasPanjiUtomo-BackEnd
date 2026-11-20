<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/todos', [TodoController::class, 'store']);
Route::get('/todos/report', [TodoController::class, 'export']);
