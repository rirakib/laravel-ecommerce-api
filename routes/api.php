<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->group(function(){

    Route::post('/login',[RegistrationController::class,'login']);

    Route::middleware('auth:sanctum')->group(function(){

        //category
        Route::get('categories',[CategoryController::class,'index']);
        Route::post('categories/store',[CategoryController::class,'store']);
        Route::get('categories/{slug}',[CategoryController::class,'view']);
        Route::post('categories/update/{slug}',[CategoryController::class,'update']);
        Route::post('categories/destroy/{slug}',[CategoryController::class,'destroy']);

        //brand
        Route::get('brand',[BrandController::class,'index']);
        Route::post('brand/store',[BrandController::class,'store']);
        Route::get('brand/{slug}',[BrandController::class,'view']);
        Route::post('brand/update/{slug}',[BrandController::class,'update']);
        Route::post('brand/destroy/{slug}',[BrandController::class,'destroy']);

    });

});

