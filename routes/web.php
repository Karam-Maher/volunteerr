<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
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
    return view('welcome');
});


Route::group(
    [
        'as' => 'dashboard.',
        'prefix' => 'admin/dashboard'
    ],
    function () {
        Route::get('/', [HomeController::class, 'index'])->name('dashboard');
        Route::get('categories/trash', [CategoryController::class, 'trash'])
            ->name('categories.trash');
        Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])
            ->name('categories.restore');
        Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])
            ->name('categories.force-delete');
        Route::resource('categories', CategoryController::class);
        Route::get('categories/trash', [CategoryController::class, 'trash'])
            ->name('categories.trash');

        Route::get('posts/trash', [PostController::class, 'trash'])
            ->name('posts.trash');
        Route::put('posts/{post}/restore', [PostController::class, 'restore'])
            ->name('posts.restore');
        Route::delete('posts/{post}/force-delete', [PostController::class, 'forceDelete'])
            ->name('posts.force-delete');
        Route::resource('posts', PostController::class);
        Route::get('posts/trash', [PostController::class, 'trash'])
            ->name('posts.trash');
    }
);
