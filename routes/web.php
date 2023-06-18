<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YoutubeChannelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WordController;

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

Route::group([
    'middleware' => 'guest:web'
], function() {


    Route::get('/', function() {
        return view('login_page');
    })->name('login_page');

    Route::post('/login', [UserController::class, 'login'])
        ->name('login');
});


Route::group([
    'middleware' => 'auth:web'
], function() {

    Route::get('/youtube_list', [YoutubeChannelController::class, 'list'])
        ->name('Youtube-list');

    Route::get('/word_list', [WordController::class, 'list'])
        ->name('Word-list');

    Route::get('/register_page', function() {
        return view('register');
    })->name('register-page');

    Route::post('/register_youtube', [YoutubeChannelController::class, 'register'])
    ->name('register-youtube');

    Route::post('/register_word', [WordController::class, 'register'])
    ->name('register-word');

    Route::get('/youtube_download', [YoutubeChannelController::class, 'download'])
        ->name('youtube-download');

    Route::post('/youtube-csv-import', [YoutubeChannelController::class, 'import'])
        ->name('youtube-csv-import');
    
});
