<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

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
}
