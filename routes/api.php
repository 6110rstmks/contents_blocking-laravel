<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YoutubeChannelController;
use App\Http\Controllers\WordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/return_channel', [YoutubeChannelController::class, 'blockChannel']);
Route::post('/return_title', [YoutubeChannelController::class, 'blockWordInTitle']);
Route::post('/return_word', [WordController::class, 'block'])
    ->name('testest');


