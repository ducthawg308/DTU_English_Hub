<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    Route::get('admin/exercise/add-topic', [App\Http\Controllers\AdminExerciseController::class, 'add_topic']);
    Route::get('admin/exercise/add-exercise', [App\Http\Controllers\AdminExerciseController::class, 'add_exercise']);
    Route::get('admin/exercise/delete/{id}', [App\Http\Controllers\AdminExerciseController::class, 'delete'])->name('delete_exercise');
    Route::get('admin/exercise/edit/{id}', [App\Http\Controllers\AdminExerciseController::class, 'edit'])->name('edit.exercise');
    Route::post('admin/exercise/store', [App\Http\Controllers\AdminExerciseController::class, 'store']);
    Route::post('admin/exercise/store-topic', [App\Http\Controllers\AdminExerciseController::class, 'store_topic']);
    Route::post('admin/exercise/store-exercise', [App\Http\Controllers\AdminExerciseController::class, 'store_exercise']);
    Route::post('admin/exercise/store-exercise1', [App\Http\Controllers\AdminExerciseController::class, 'store_exercise1']);
    Route::post('admin/exercise/store-audio', [App\Http\Controllers\AdminExerciseController::class, 'store_audio']);
    Route::get('admin/exercise/delete_audio/{id}', [App\Http\Controllers\AdminExerciseController::class, 'delete_audio'])->name('delete_audio');
    Route::post('admin/exercise/update/{id}', [App\Http\Controllers\AdminExerciseController::class, 'update'])->name('update.exercise');

    Route::get('admin/exam/list', [App\Http\Controllers\AdminExamController::class, 'list']);
    Route::get('admin/exam/add', [App\Http\Controllers\AdminExamController::class, 'add']);
    Route::get('admin/exam/delete/{id}', [App\Http\Controllers\AdminExamController::class, 'delete'])->name('delete_exam');
    Route::get('admin/exam/edit/{id}', [App\Http\Controllers\AdminExamController::class, 'edit'])->name('edit.exam');
    Route::post('admin/exam/store', [App\Http\Controllers\AdminExamController::class, 'store']);
    Route::post('admin/exam/update/{id}', [App\Http\Controllers\AdminExamController::class, 'update'])->name('update.exam');

    Route::get('admin/vocabulary/list', [App\Http\Controllers\AdminVocabularyController::class, 'list']);
    Route::get('admin/vocabulary/add', [App\Http\Controllers\AdminVocabularyController::class, 'add']);
    Route::get('admin/vocabulary/edit/{id}', [App\Http\Controllers\AdminVocabularyController::class, 'edit'])->name('edit.vocab');
    Route::get('admin/vocabulary/delete/{id}', [App\Http\Controllers\AdminVocabularyController::class, 'delete'])->name('delete_vocab');
    Route::post('admin/vocabulary/update/{id}', [App\Http\Controllers\AdminVocabularyController::class, 'update'])->name('update.vocab');
});

Route::middleware(['auth','verified'])->group(function(){
    Route::get('home/vocabulary/custom/addtopic', [App\Http\Controllers\VocabularyController::class, 'addtopic'])->name('addtopic.custom');
    Route::post('home/vocabulary/custom/addtopic/storetopic', [App\Http\Controllers\VocabularyController::class, 'storetopic']);
    Route::get('home/vocabulary/custom/addvocab', [App\Http\Controllers\VocabularyController::class, 'addvocab'])->name('addvocab.custom');
    Route::post('home/vocabulary/custom/addtopic/storevocab', [App\Http\Controllers\VocabularyController::class, 'storevocab']);
    Route::get('home/vocabulary/custom/topic', [App\Http\Controllers\VocabularyController::class, 'topiccustom'])->name('topic.custom');
    Route::get('home/vocabulary/custom/learn/{id}', [App\Http\Controllers\VocabularyController::class, 'learncustom'])->name('learn.custom');
    Route::get('home/vocabulary/custom', [App\Http\Controllers\VocabularyController::class, 'custom'])->name('custom.vocabulary');
    Route::get('home/vocabulary/custom/delete/{id}', [App\Http\Controllers\VocabularyController::class, 'delete'])->name('delete.custom');
});

Route::get('home/topic', [App\Http\Controllers\ExercisesController::class, 'list'])->name('list.topic');
Route::get('home/topic/{id}', [App\Http\Controllers\ExercisesController::class, 'show'])->name('topic.show');
Route::get('home/topic/{topicId}/{id}', [App\Http\Controllers\ExercisesController::class, 'listening'])->name('topic.listening');
Route::post('home/topic/{id}/check', [App\Http\Controllers\ExercisesController::class, 'check'])->name('check.answer');

Route::post('/vnpay_payment', [App\Http\Controllers\PaymentController::class, 'vnpay_payment']);
Route::get('/home/topic_payment', [App\Http\Controllers\PaymentController::class, 'handleVNPayCallback']);

Route::get('home/vocabulary', [App\Http\Controllers\VocabularyController::class, 'home'])->name('home.vocabulary');
Route::get('home/vocabulary/topic', [App\Http\Controllers\VocabularyController::class, 'topic'])->name('topic.vocabulary');
Route::get('home/vocabulary/default/{id}', [App\Http\Controllers\VocabularyController::class, 'default'])->name('default.vocabulary');
Route::get('home/vocabulary/review/{id}', [App\Http\Controllers\VocabularyController::class, 'review'])->name('review.vocabulary');
