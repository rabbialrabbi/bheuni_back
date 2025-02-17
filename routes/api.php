<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {

    /*Routes for lead*/
    Route::get('dashboard-data', [UserController::class,'dashboardData']);
    Route::resource('leads', LeadController::class)->only(['index','update']);
    Route::put('leads/{lead}/status', [LeadController::class,'status']);
    Route::post('leads/{lead}/application', [LeadController::class,'application']);
    Route::get('counselors', [UserController::class,'index']);

    /*Routes for application*/
    Route::resource('application', ApplicationController::class)->only(['index','update']);

});
