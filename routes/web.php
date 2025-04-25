<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('', function () {
    return view('home');
})->name('home');

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('home', function () {
    return view('home');
})->name('home');


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
    Route::get('admin/vocabulary/addtopic', [App\Http\Controllers\AdminVocabularyController::class, 'addtopic']);
    Route::post('admin/vocabulary/addtopic/storetopic', [App\Http\Controllers\AdminVocabularyController::class, 'storetopic']);
    Route::get('admin/vocabulary/addvocab', [App\Http\Controllers\AdminVocabularyController::class, 'addvocab']);
    Route::post('admin/vocabulary/addtopic/storevocab', [App\Http\Controllers\AdminVocabularyController::class, 'storevocab']);
    Route::get('admin/vocabulary/edit/{id}', [App\Http\Controllers\AdminVocabularyController::class, 'edit'])->name('edit.vocab');
    Route::get('admin/vocabulary/delete/{id}', [App\Http\Controllers\AdminVocabularyController::class, 'delete'])->name('delete_vocab');
    Route::post('admin/vocabulary/update/{id}', [App\Http\Controllers\AdminVocabularyController::class, 'update'])->name('update.vocab');
});

Route::middleware(['auth','verified'])->group(function(){
    Route::get('setting', [App\Http\Controllers\UserController::class, 'index'])->name('user.setting');

    Route::get('home/vocabulary/custom/addtopic', [App\Http\Controllers\VocabularyController::class, 'addtopic'])->name('addtopic.custom');
    Route::post('home/vocabulary/custom/addtopic/storetopic', [App\Http\Controllers\VocabularyController::class, 'storetopic']);
    Route::get('home/vocabulary/custom/addvocab', [App\Http\Controllers\VocabularyController::class, 'addvocab'])->name('addvocab.custom');
    Route::post('home/vocabulary/custom/addtopic/storevocab', [App\Http\Controllers\VocabularyController::class, 'storevocab']);
    Route::get('home/vocabulary/custom/topic', [App\Http\Controllers\VocabularyController::class, 'topiccustom'])->name('topic.custom');
    Route::get('home/vocabulary/custom/learn/{id}', [App\Http\Controllers\VocabularyController::class, 'learncustom'])->name('learn.custom');
    Route::get('home/vocabulary/custom', [App\Http\Controllers\VocabularyController::class, 'custom'])->name('custom.vocabulary');
    Route::get('home/vocabulary/custom/edit/{id}', [App\Http\Controllers\VocabularyController::class, 'edit'])->name('edit.vocabUser');
    Route::post('home/vocabulary/custom/update/{id}', [App\Http\Controllers\VocabularyController::class, 'update'])->name('update.vocabUser');
    Route::get('home/vocabulary/custom/delete/{id}', [App\Http\Controllers\VocabularyController::class, 'delete'])->name('delete.custom');

    Route::get('home/vocabulary/custom/ai', [App\Http\Controllers\VocabularyController::class, 'ai'])->name('ai.custom');
    Route::post('/vocabularyAI', [App\Http\Controllers\VocabularyController::class, 'generateVocabulary'])->name('generate.vocabulary');
    Route::post('/save-vocabulary', [App\Http\Controllers\VocabularyController::class, 'saveVocabulary'])->name('save.vocabulary');

    Route::get('exam', [App\Http\Controllers\ExamController::class, 'list'])->name('home.exam');
    Route::get('exam/{id}', [App\Http\Controllers\ExamController::class, 'detail'])->name('exam.detail');
    Route::post('exam/{id}/submit', [App\Http\Controllers\ExamController::class, 'submitTest'])->name('exam.submit');
    Route::get('result/{id}', [App\Http\Controllers\ExamController::class, 'showResult'])->name('exam.result');

    Route::post('/vnpay_payment', [App\Http\Controllers\PaymentController::class, 'vnpay_payment']);
    Route::get('/home/topic_payment', [App\Http\Controllers\PaymentController::class, 'handleVNPayCallback']);

    Route::get('community/create', [App\Http\Controllers\CommunityController::class, 'create'])->name('create.community');
    Route::post('community/store', [App\Http\Controllers\CommunityController::class, 'store'])->name('store.community');
    Route::post('community/storeTL', [App\Http\Controllers\CommunityController::class, 'storeTL'])->name('storeTL.community');

    Route::get('/reading', [App\Http\Controllers\ReadingController::class, 'index'])->name('index.reading');
    Route::post('/reading/generate', [App\Http\Controllers\ReadingController::class, 'generateReading'])->name('generate.reading');
    Route::post('/reading/save', [App\Http\Controllers\ReadingController::class, 'saveReading'])->name('save.reading');
    
    Route::get('/writing', [App\Http\Controllers\WritingController::class, 'index'])->name('index.writing');
    Route::post('/writing/generate-prompt', [App\Http\Controllers\WritingController::class, 'generatePrompt'])->name('writing.generate-prompt');
    Route::post('/writing/evaluate', [App\Http\Controllers\WritingController::class, 'evaluateWriting'])->name('writing.evaluate');
});

Route::get('topic', [App\Http\Controllers\ExercisesController::class, 'list'])->name('list.topic');
Route::get('topic/{id}', [App\Http\Controllers\ExercisesController::class, 'show'])->name('topic.show');
Route::get('topic/{topicId}/{id}', [App\Http\Controllers\ExercisesController::class, 'listening'])->name('topic.listening');
Route::post('topic/{id}/check', [App\Http\Controllers\ExercisesController::class, 'check'])->name('check.answer');
Route::get('hint/{id}', [App\Http\Controllers\ExercisesController::class, 'hint'])->name('hint');
Route::get('/show-answer/{id}', [App\Http\Controllers\ExercisesController::class, 'showAnswer'])->name('show.answer');

Route::get('vocabulary', [App\Http\Controllers\VocabularyController::class, 'home'])->name('home.vocabulary');
Route::get('vocabulary/topic', [App\Http\Controllers\VocabularyController::class, 'topic'])->name('topic.vocabulary');
Route::get('vocabulary/default/{id}', [App\Http\Controllers\VocabularyController::class, 'default'])->name('default.vocabulary');
Route::get('vocabulary/review/{id}', [App\Http\Controllers\VocabularyController::class, 'review'])->name('review.vocabulary');

// Donate
Route::get('donate', [App\Http\Controllers\DonateController::class, 'show'])->name('home.donate');
Route::post('donate/generate', [App\Http\Controllers\DonateController::class, 'generate'])->name('donate.generate');

//Community
Route::get('community', [App\Http\Controllers\CommunityController::class, 'index'])->name('home.community');
Route::get('community/detail/{id}', [App\Http\Controllers\CommunityController::class, 'detail'])->name('detail.community');
Route::post('community/{id}/like', [App\Http\Controllers\CommunityController::class, 'toggleLike'])->name('like.community');
Route::post('community/comment/store', [App\Http\Controllers\CommunityController::class, 'storeComment'])->name('storeComment.community');
Route::get('community/document/{id}', [App\Http\Controllers\CommunityController::class, 'show'])->name('document.show');
Route::get('/community/download/{id}', [App\Http\Controllers\CommunityController::class, 'download'])->name('document.download');


// AI
Route::get('/gemini', [App\Http\Controllers\GeminiController::class, 'callGemini']);

//Pronounce
Route::get('pronounce', function () {
    return view('pronounce.index');
})->name('home.pronounce');

//Assistant
// 1. Route hiển thị giao diện tương tác giọng nói
Route::get('/voice-interaction', [App\Http\Controllers\VoiceInteractionController::class, 'index'])->name('voice.interaction');
// 2. Route xử lý câu hỏi từ giọng nói
Route::post('/process-voice', [App\Http\Controllers\VoiceInteractionController::class, 'processVoice'])->name('process.voice');
// 3. Route phát audio đã lưu
Route::get('/play-audio/{audioId}', [App\Http\Controllers\VoiceInteractionController::class, 'playAudio'])->name('play.audio');