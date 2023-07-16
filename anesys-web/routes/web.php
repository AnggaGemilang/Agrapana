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

Route::get('/auth/login', [MonitoringController::class, 'login'])->name('auth.login');
Route::post('/auth/login/post', [MonitoringController::class, 'loginPost'])->name('auth.login.post');
Route::get('/auth/logout/post', [MonitoringController::class, 'logoutPost'])->name('auth.logout.post');
Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
