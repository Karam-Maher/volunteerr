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
Route::group([
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard'
],
function(){
    Route::get('/',[HomeController::class,'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
});
