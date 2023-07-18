<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FieldController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace'  => 'App\Http\Controllers\Api',
], function () {
    Route::apiResource('monitoring-main-devices', 'MonitoringMainDeviceController');
    Route::apiResource('monitoring-support-devices', 'MonitoringSupportDeviceController');
    Route::get('/login/post', [AuthController::class, 'login']);
    Route::get('/field/{id}', [FieldController::class, 'show']);
});
