<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;

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
Auth::routes();

Route::get('/', [PagesController::class, 'index']);

Route::prefix('/settings')->name('settings.')->group(function () {
    Route::get('/', [UsersController::class, 'profile'])->name('profile');
    Route::post('settings', [UsersController::class, 'updateProfile'])->name('updateProfile');
    Route::post('settings/password', [UsersController::class, 'updatePassword'])->name('changePassword');
});
