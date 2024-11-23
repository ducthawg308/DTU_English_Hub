<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth','verified'])->group(function(){
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'show']);
    Route::get('admin', [App\Http\Controllers\DashboardController::class, 'show']);
    Route::get('admin/users/list', [App\Http\Controllers\AdminUsersController::class, 'list']);
    Route::get('admin/users/add', [App\Http\Controllers\AdminUsersController::class, 'add']);
    Route::post('admin/users/store', [App\Http\Controllers\AdminUsersController::class, 'store']);
    Route::get('admin/users/delete/{id}', [App\Http\Controllers\AdminUsersController::class, 'delete'])->name('delete_user');
    Route::get('admin/users/edit/{id}', [App\Http\Controllers\AdminUsersController::class, 'edit'])->name('edit.user');
    Route::post('admin/users/update/{id}', [App\Http\Controllers\AdminUsersController::class, 'update'])->name('update.user');
});