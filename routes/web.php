<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

        Route::get('/', [AdminAuthController::class, 'show'])->name('login.show');
        Route::get('/login', [AdminAuthController::class, 'show'])->name('login.show');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::group(['middleware' => 'adminAuth'], function () {

            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');

            Route::get('/news', [NewsController::class, 'index'])->name('news_list');
            Route::get('news/create', [NewsController::class, 'create'])->name('news_create');

            Route::get('/category', [CategoryController::class, 'index'])->name('category_list');
            Route::get('category/create', [CategoryController::class, 'create'])->name('create_category');
            Route::post('/category/store', [CategoryController::class, 'store'])->name('store_category');
            Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('edit_category');
            Route::put('/category/{id}', [CategoryController::class, 'update'])->name('update_category');
            Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('delete_category');

            Route::get('/author', [AuthorController::class, 'index'])->name('author_list');
            Route::get('/author1', [AuthorController::class, 'index'])->name('author_list');

        });

    });

});

