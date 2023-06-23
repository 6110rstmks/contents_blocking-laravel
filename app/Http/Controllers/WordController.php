<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Common\BlockTarget;

use Log;

class WordController extends Controller
{
    protected $blocktarget;

    public function __construct(BlockTarget $blocktarget) {
        $this->blockTarget = $blocktarget;
    }

    public function list() {
        $word_blackList = Word::all();
        $cnt = $this->blockTarget->getCnt("YoutubeChannel");

        return view('word-list')
            ->with([
                'word_blackList' => $word_blackList,
            ]);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|unique:words'
        ]);

        Word::create([
           'name' => $request->name
        ]);

        return redirect()->route('register-page');
    }

    public function block(Request $request) {
        $words_in_db = Word::all()->pluck("name");
        $title = $request->input('title');
        $title = preg_replace('/　/u', '', $title);  // delete multibyte space
        $title = str_replace(' ', '', $title); // delete singlebyte space

        // stripos() is case-insensitive version of strpos()
        foreach ($words_in_db as $data) {
            // Log::debug($data);
            if (stripos($title, $data) != false || stripos($title, $data) === 0) {
                return 1;
            }
        }
        return 0;
    }

    public function import(Request $request) {
        $this->blockTarget->import("Word", $request);
        return redirect()->back();
    }

    public function download() {
        $path = public_path('/storage/dummy.txt');
        $fileName = $this->blockTarget->download("Word", $path);
        return response()->download($path, $fileName, ['Content-Type: text/plain']);
    }
}
