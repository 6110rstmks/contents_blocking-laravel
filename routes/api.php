<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YoutubeChannelController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\SiteController;
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


Route::post('/return_youtube', [YoutubeChannelController::class, 'block']);
Route::post('/return_word', [WordController::class, 'block']);
Route::post('/return_search_word', [WordController::class, 'searchBlock']);
Route::post('/return_site', [SiteController::class, 'block']);

