<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', [FrontEndController::class, 'index'])->name('index');

// Handle Login & Register
Route::get('/auth/login', [LoginController::class, 'index'])->name('auth.login');
Route::post('/auth/login/post', [LoginController::class, 'handleLogin'])->name('auth.login.post');

Route::group(['prefix' => 'master', 'middleware' => ['auth:web,webstudent,webclient', 'verified']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Role Operator
    Route::group(['middleware' => ['role:Operator']], function () {

    });

    // Role Client
    Route::group(['middleware' => ['role:Client']], function () {

    });

});
