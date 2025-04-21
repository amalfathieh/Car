<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
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
        Route::get('/', 'getCars')->withoutMiddleware('auth:sanctum');
        Route::get('/{id}', 'getCar')->withoutMiddleware('auth:sanctum');
        Route::put('/{id}', 'update');
        Route::delete('/{car}', 'delete');
    });

    Route::controller(AdController::class)->prefix('ads')->group(function () {
        Route::post('/', 'create')->middleware(AdminMiddleware::class);
        Route::get('/', 'getAds')->withoutMiddleware('auth:sanctum');
        Route::get('/{id}', 'getAd')->withoutMiddleware('auth:sanctum');
        Route::put('/{id}', 'updateAd')->middleware(AdminMiddleware::class);
        Route::delete('/{id}', 'delete')->middleware(AdminMiddleware::class);
    });

    Route::middleware([AdminMiddleware::class])->group(function (){

        Route::controller(ComplaintController::class)->prefix('complaints')->group(function () {
            Route::post('/', 'create')->withoutMiddleware(['auth:sanctum',AdminMiddleware::class]);
            Route::get('/', 'getComplaints');
            Route::get('/public', 'getAcceptedComplaints')->withoutMiddleware(['auth:sanctum',AdminMiddleware::class]);
            Route::get('/{id}', 'getComplaint');
            Route::put('/updateStatus/{id}', 'updateStatus');
            Route::delete('/{id}', 'delete');
        });

        Route::controller(SettingController::class)->prefix('setting')->group(function () {
            Route::post('/', 'create');
            Route::get('/{id}', 'getSetting')->withoutMiddleware(['auth:sanctum',AdminMiddleware::class]);
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });
    });


});




