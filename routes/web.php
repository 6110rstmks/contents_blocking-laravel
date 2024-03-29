<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YoutubeChannelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\YoutubeApiController;

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

    Route::get('/site_list', [SiteController::class, 'list'])
        ->name('Site-list');

    Route::get('/register_page', function() {
        return view('register');
    })->name('register-page');

    Route::post('/register_youtube', [YoutubeChannelController::class, 'register'])
    ->name('register-youtube');
    Route::post('/register_word', [WordController::class, 'register'])
    ->name('register-word');
    Route::post('/register_site', [SiteController::class, 'register'])
    ->name('register-site');
    Route::post('/register_api', [YoutubeApiController::class, 'register'])
    ->name('register-api');

    Route::get('/youtube_download', [YoutubeChannelController::class, 'export'])
        ->name('youtube-download');
    Route::get('/word_download', [WordController::class, 'export'])
        ->name('word-download');
    Route::get('/site_download', [SiteController::class, 'export'])
        ->name('site-download');
    Route::get('/site_for_hosts_download', [SiteController::class, 'export_for_hostsfile'])
        ->name('site_for_hosts-download');

    Route::post('/youtube-csv-import', [YoutubeChannelController::class, 'import'])
        ->name('youtube-csv-import');
    Route::post('/word-csv-import', [WordController::class, 'import'])
        ->name('word-csv-import');
    Route::post('/site-csv-import', [SiteController::class, 'import'])
        ->name('site-csv-import');

    Route::post('/word_temporary_unblock/{word}', [WordController::class, 'temporaryUnblock'])
        ->name('word-temporary-unblock');

    Route::post('/word_unblock/{word}', [WordController::class, 'unblock'])
        ->name('word-unblock');

    Route::get('/dev-block-test-page', [WordController::class, 'testBlock']);

    Route::post('/return_word', [YoutubeChannelController::class, 'block'])
        ->name('ricepizza');

    Route::post('/register_user', [UserController::class, 'register'])
    ->name('register-user');
});
