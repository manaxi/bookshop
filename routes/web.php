<?php

use App\Http\Controllers\User\RatingsController;
use App\Http\Controllers\User\ReportsController;
use App\Http\Controllers\User\ReviewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\BooksController as BooksControllerUser;
use App\Http\Controllers\Admin\BooksController as BooksControllerAdmin;
use App\Http\Controllers\Admin\AuthorsController;
use App\Http\Controllers\Admin\GenresController;
use App\Http\Controllers\Admin\ReportsController as ReportsControllerAdmin;

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

Route::get('/', [BooksController::class, 'index'])->name('index');
Route::resource('books', BooksController::class);

Route::group(['middleware' => ['role:User']], function () {
    Route::resource('ratings', RatingsController::class);
    Route::resource('reviews', ReviewsController::class);
    Route::resource('reports', ReportsController::class);

    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'profile'])->name('show');
        Route::post('settings', [SettingsController::class, 'updateProfile'])->name('updateProfile');
        Route::post('settings/password', [SettingsController::class, 'updatePassword'])->name('changePassword');
    });

    Route::prefix('/dashboard')->name('dashboard.')->group(function () {
        Route::resource('books', BooksControllerUser::class);
    });
});

Route::prefix('/admin')->name('admin.')->middleware('role:Admin')->group(function () {
    Route::view('/', 'admin.index')->name('index');
    //books
    Route::resource('books', BooksControllerAdmin::class);
    //authors
    Route::resource('authors', AuthorsController::class);
    //genres
    Route::resource('genres', GenresController::class);
    //reports
    Route::resource('reports', ReportsControllerAdmin::class);
});

