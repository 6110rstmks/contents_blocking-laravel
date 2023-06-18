<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

use Log;
class WordController extends Controller
{
    public function list() {
        $word_blackList = Word::all();
        return view('word-list')
            ->with([
                'word_blackList' => $word_blackList,
            ]);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'unique:youtube_channels'
        ], [
            'name.unique' => 'This channel_name is already registered.'
        ]);


        Word::create([
           'name' => $request->word_name
        ]);

        return redirect()->route('register-page');
    }
    public function block() {

        $words_in_db = Word::all()->pluck("name");

        Log::debug($words_in_db);


        $title = " one piece』コミックス一覧";

        $title = preg_replace('/　/u', '', $title);  // 全角空白を除去する

        // stripost is case-insensitive version of strpos()
        foreach ($words_in_db as $data) {
            if (stripos($title, $data) != false) {
                Log::debug('ok');
            } else {
                Log::debug('NG');
            }
        }

    }
}
