<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BooksController;

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

Route::prefix('/dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    //Users books crud routing
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('create', [BooksController::class, 'create'])->name('create');
        Route::post('store', [BooksController::class, 'store'])->name('store');
        Route::get('edit', [BooksController::class, 'edit'])->name('edit');
        Route::patch('update-{id}', [BooksController::class, 'update'])->name('update');
        Route::delete('delete-{id}', [BooksController::class, 'destroy'])->name('delete');
    });
});
