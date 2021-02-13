<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\dashboard\UsersController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\BooksController;
use App\Http\Controllers\admin\BooksController as BooksAdminController;
use App\Http\Controllers\admin\AuthorsController;
use App\Http\Controllers\admin\GenresController;

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

Route::get('/', [PagesController::class, 'index'])->name('index');
Route::get('/book/{slug}', [PagesController::class, 'show_book'])->name('show_book');

Route::prefix('/settings')->name('settings.')->middleware('role:User')->group(function () {
    Route::get('/', [UsersController::class, 'profile'])->name('profile');
    Route::post('settings', [UsersController::class, 'updateProfile'])->name('updateProfile');
    Route::post('settings/password', [UsersController::class, 'updatePassword'])->name('changePassword');
});

Route::prefix('/dashboard')->name('dashboard.')->middleware('role:User')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::resource('books', BooksController::class);
});

Route::prefix('/admin')->name('admin.')->middleware('role:Admin')->group(function () {
    Route::view('/', 'admin.index')->name('index');
    //books
    Route::resource('books', BooksAdminController::class);
    //authors
    Route::resource('authors', AuthorsController::class);
    //genres
    Route::resource('genres', GenresController::class);
});

