<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
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

Route::get('/', [PublicController::class, 'index'])->name('presence');
Route::post('/post', [PublicController::class, 'postPresence'])->name('presence.post');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/login/post', [AdminController::class, 'loginPost'])->name('admin.login.post');
Route::get('admin/logout/post', [AdminController::class, 'logoutPost'])->name('admin.logout.post');
Route::get('/admin/manage', [AdminController::class, 'getManage'])->name('admin.manage');
