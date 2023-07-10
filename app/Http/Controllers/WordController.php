<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Common\BlockTarget;

use Log;
use Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;


class WordController extends Controller
{
    protected $blockTarget;

    public $endTime;

    public function __construct(BlockTarget $blockTarget) {
        $this->blockTarget = $blockTarget;
    }

    public function testBlock() {


        return view('test-page');
    }

    public function list() {

        $lists1 = Word::all()->where('genre', 1);
        $lists2 = Word::all()->where('genre', 2);
        $lists3 = Word::all()->where('genre', 3);
        $cnt = $this->blockTarget->getCnt("Word");
        $nowTime = Carbon::now();
        $endTime = session('endTime');
        if ($nowTime->gte($endTime)) {
            Word::where('disableFlg', 1)->update(['disableFlg' => 0]);
            session()->forget('endTime');
            if (Auth::user()->dayLimit === 0) {
                Auth::user()->dayLimit = 1;
                Auth::user()->save();
            }
        }

        $diffTime = $nowTime->diffInMinutes($endTime);

        return view('word-list')
            ->with([
                'lists1' => $lists1,
                'lists2' => $lists2,
                'lists3' => $lists3,
                'cnt' => $cnt,
                'filename' => "word",
                'diffTime'=> $diffTime
            ]);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|unique:words',
            'genre'=> 'required'
        ]);

        $blockWord = ltrim($request->name);

        if (strpos($blockWord, '　') !== false || strpos($blockWord, ' ') !== false) {
            return \Redirect::back()->withErrors(['Don\'t put spaces between words']);
        }

        $number = $request->genre;

        Word::create([
           'name' => $blockWord,
           'genre'=> $number,
        ]);

        return redirect()->route('register-page');
    }

    public function block(Request $request) {
        $nowTime = Carbon::now();
        Log::debug(session('endTime'));

        if ($nowTime->gte(session('endTime'))) {
            Word::where('disableFlg', 1)->update(['disableFlg' => 0]);
            Word::save();
            session()->forget('endTime');
            if (Auth::user()->dayLimit === 0) {
                Auth::user()->dayLimit = 1;
                Auth::user()->save();
            }
        }
        $words_in_db = Word::all()->where('disableFlg', 0)->pluck("name");
        // Log::debug($words_in_db);
        $title = $request->input('title');
        $title = preg_replace('/　/u', '', $title);  // delete multibyte space
        $title = str_replace(' ', '', $title); // delete singlebyte space

        // stripos() is case-insensitive version of strpos()
        foreach ($words_in_db as $data) {
            if (stripos($title, $data) != false || stripos($title, $data) === 0) {
                return $data;
            }
        }
        return 0;
    }

    public function temporaryUnblock(Word $word) {
        $CntOfDisabledBlockedWord = Word::where('disableFlg', 1)->count();

        if (Auth::user()->dayLimit === 1) {
            return \Redirect::back()->withErrors(['本日の制限解除は一度行ったためできません。']);
        }

        if ($CntOfDisabledBlockedWord >= 3) {
            return \Redirect::back()->withErrors(['一日のunblock回数はすでに満たしています。']);
        } elseif ($CntOfDisabledBlockedWord <= 2 && $CntOfDisabledBlockedWord >= 0) {
            $word->disableFlg += 1;
            $word->save();
            if ($CntOfDisabledBlockedWord === 0) {
                session(['endTime' => Carbon::now()->addMinutes(30)]);
            }
            return redirect()->back();
        } else {
            return \Redirect::back()->withErrors(['なんか変なことおきてる']);

        }

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
