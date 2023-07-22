<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FieldController;
use App\Http\Controllers\Api\MonitoringMainDeviceController;
use App\Http\Controllers\Api\MonitoringSupportDeviceController;
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

    Route::get('/monitoring-main-devices/get-by-column/{id}/{column}', [MonitoringMainDeviceController::class, 'getByColumn']);
    Route::get('/monitoring-support-devices/get-by-column/{id}/{number}/{column}', [MonitoringSupportDeviceController::class, 'getByColumn']);

    Route::get('/login/post', [AuthController::class, 'login']);
    Route::get('/field/{id}', [FieldController::class, 'show']);
});
