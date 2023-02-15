<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TempFileController;
use App\Http\Controllers\Admin\WorkController;
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

Route::middleware('not.admin')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
});

Route::post('/login', [AuthController::class, 'login'])->name('admin_login');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin_logout');


// upload temporary file using filepond
Route::post('/temp-upload', [TempFileController::class, 'temp_upload']);
Route::delete('/temp-delete', [TempFileController::class, 'temp_delete']);
Route::get('/temp-load', [TempFileController::class, 'temp_load']);

Route::middleware('is.admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.main');
    })->name('dashboard');

    // Work Controller
    Route::resource('works', WorkController::class);
    Route::get('/create-slug', [WorkController::class, 'create_slug']);

    // Service Controller
    Route::resource('services', ServiceController::class);
});
