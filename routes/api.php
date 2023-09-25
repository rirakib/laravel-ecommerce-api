<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CategoryController;

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
        Route::get('categories',[CategoryController::class,'index']);
        Route::post('categories/store',[CategoryController::class,'store']);
    });

});

