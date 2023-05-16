<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

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

Route::view('/', 'chat')->name('chat.index');

Route::view('/chat-reply', 'chat-reply')->name('chat.reply');

Route::post('/chat', [ChatController::class, 'sendMessage']);
