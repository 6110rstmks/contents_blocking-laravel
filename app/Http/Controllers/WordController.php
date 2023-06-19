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
    public function block(Request $request) {


        $words_in_db = Word::all()->pluck("name");

        $title = $request->input('title');
        $title = preg_replace('/　/u', '', $title);  // 全角空白を除去する
        $title = str_replace(' ', '', $title);
        Log::debug($title . ":title");

        // stripost is case-insensitive version of strpos()
        foreach ($words_in_db as $data) {
            Log::debug($data);
            if (stripos($title, $data) != false || stripos($title, $data) === 0) {
            // if (stripos($title, $data) != false) {
                Log::debug("0行目" . stripos($title, $data));
                return 1;
            }
        }

        return 0;

    }
}
