<?php

use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/monitoring/login', function () {
    return view('pages.auth.login');
});

// Route::get('/monitoring/register', function () {
//     return view('pages.auth.register');
// });

Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');

Route::get('/monitoring/plant-list', [MonitoringController::class, 'plants'])->name('monitoring.plants');
Route::get('/monitoring/plant-list/get', [MonitoringController::class, 'plantByType'])->name('monitoring.plant.get');

Route::get('/monitoring/presets', [MonitoringController::class, 'presets'])->name('monitoring.presets');
Route::get('/monitoring/presets/get', [MonitoringController::class, 'presetByType'])->name('monitoring.preset.get');

Route::get('/monitoring/login', [MonitoringController::class, 'login'])->name('monitoring.login');
Route::post('/monitoring/login/post', [MonitoringController::class, 'loginPost'])->name('monitoring.login.post');
Route::get('/monitoring/logout/post', [MonitoringController::class, 'logoutPost'])->name('monitoring.logout.post');
