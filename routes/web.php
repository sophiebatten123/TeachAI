<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\DocumentController;

Route::get('/download-presentation', [PresentationController::class, 'download'])->name('presentation.download');
Route::get('/download-document/{lessonId}', [DocumentController::class, 'download'])->name('document.download');

Route::middleware("auth")->group(function () {
    Route::get('plans', [PlanController::class, 'index']);
    Route::get('plans/{plan}', [PlanController::class, 'show'])->name("plans.show");
    Route::post('subscription', [PlanController::class, 'subscription'])->name("subscription.create");
});

Route::post('/create-powerpoint', [ChatController::class, 'createPowerPoint'])->name('create-powerpoint');

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

Auth::routes();

Route::view('/', 'chat')->name('chat.index');

Route::view('/chat-reply', 'chat-reply')->name('chat.reply');

Route::post('/chat', [ChatController::class, 'sendMessage']);

// Login, register and logout features

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
