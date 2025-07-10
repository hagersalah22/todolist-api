<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/todos',  [TodoController::class, 'index']);   
    Route::post('/todos', [TodoController::class, 'store']);  
    Route::get('/todos/{todo}',[TodoController::class, 'show']);    
    Route::post('/todos/{todo}',[TodoController::class, 'update']);  
    Route::delete('/todos/{todo}',[TodoController::class, 'destroy']);
});