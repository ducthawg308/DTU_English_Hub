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


Route::middleware(['auth','verified','CheckRole:user'])->group(function(){
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'show']);
    Route::get('admin/users/list', [App\Http\Controllers\AdminUsersController::class, 'list']);
    Route::get('admin/users/add', [App\Http\Controllers\AdminUsersController::class, 'add']);
    Route::post('admin/users/store', [App\Http\Controllers\AdminUsersController::class, 'store']);
    Route::get('admin/users/delete/{id}', [App\Http\Controllers\AdminUsersController::class, 'delete'])->name('delete_user');
    Route::get('admin/users/edit/{id}', [App\Http\Controllers\AdminUsersController::class, 'edit'])->name('edit.user');
    Route::post('admin/users/update/{id}', [App\Http\Controllers\AdminUsersController::class, 'update'])->name('update.user');

    Route::get('admin/exercise/list', [App\Http\Controllers\AdminExerciseController::class, 'list']);
    Route::get('admin/exercise/add', [App\Http\Controllers\AdminExerciseController::class, 'add']);
    Route::get('admin/exercise/delete/{id}', [App\Http\Controllers\AdminExerciseController::class, 'delete'])->name('delete_exercise');
    Route::get('admin/exercise/edit/{id}', [App\Http\Controllers\AdminExerciseController::class, 'edit'])->name('edit.exercise');
    Route::post('admin/exercise/store', [App\Http\Controllers\AdminExerciseController::class, 'store']);
    Route::post('admin/exercise/update/{id}', [App\Http\Controllers\AdminExerciseController::class, 'update'])->name('update.exercise');

    Route::get('admin/exam/list', [App\Http\Controllers\AdminExamController::class, 'list']);
    Route::get('admin/exam/add', [App\Http\Controllers\AdminExamController::class, 'add']);
    Route::get('admin/exam/delete/{id}', [App\Http\Controllers\AdminExamController::class, 'delete'])->name('delete_exercise');
    Route::get('admin/exam/edit/{id}', [App\Http\Controllers\AdminExamController::class, 'edit'])->name('edit.exercise');
    Route::post('admin/exam/store', [App\Http\Controllers\AdminExamController::class, 'store']);
    Route::post('admin/exam/update/{id}', [App\Http\Controllers\AdminExamController::class, 'update'])->name('update.exercise');
});

Route::get('home/topic', [App\Http\Controllers\TopicController::class, 'list'])->name('list.topic');
Route::get('home/topic/{id}', [App\Http\Controllers\TopicController::class, 'show'])->name('topic.show');
Route::get('home/topic/{topicId}/{id}', [App\Http\Controllers\TopicController::class, 'listening'])->name('topic.listening');