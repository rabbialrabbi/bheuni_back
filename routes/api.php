<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthController::class,'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('leads', LeadController::class);
Route::put('leads/{lead}/status', [LeadController::class,'status']);
Route::post('leads/{lead}/application', [LeadController::class,'application']);
Route::get('counselors', [UserController::class,'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
});
