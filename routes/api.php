<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout',[UserController::class,'logout']);
    Route::get('user/delete',[UserController::class,'delete']);

    Route::controller(CarController::class)->prefix('car')->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'getCars');
        Route::get('/{id}', 'getCar');
        Route::put('/{id}', 'update');
        Route::delete('/{car}', 'delete');
    });
});


