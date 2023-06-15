<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YoutubeChannelController;
use App\Http\Controllers\UserController;

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

    Route::get('/list', [YoutubeChannelController::class, 'list'])
        ->name('list');
        
    Route::get('/register_page', function() {
        return view('register');
    })->name('register-page');

    Route::post('/register', [YoutubeChannelController::class, 'register'])
    ->name('register');
});