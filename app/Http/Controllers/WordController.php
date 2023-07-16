<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\User;
use App\Common\BlockTarget;

use Log;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;



class WordController extends Controller
{
    protected $blockTarget;

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
        $user = User::find(1);
        $endTime = $user->timeLimit;

        $this->timeComparison($nowTime, $endTime);

        $interval = $nowTime->diffAsCarbonInterval($endTime, false);

        if ($interval->invert == 0) {
        } else {
            $interval = null;
        }


        return view('word-list')
            ->with([
                'lists1' => $lists1,
                'lists2' => $lists2,
                'lists3' => $lists3,
                'cnt' => $cnt,
                'diffTime'=> $interval
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
        $endTime = User::find(1)->timeLimit;
        $this->timeComparison($nowTime, $endTime);

        $words_in_db = Word::all()->where('disableFlg', 0)->pluck("name");
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

    public function timeComparison($nowTime, $endTime) {
        if (!is_null($endTime) && $nowTime->gte($endTime)) {
            Word::where('disableFlg', 1)->update(['disableFlg' => 0]);
            $user = User::find(1);
            if ($user->dayLimit === 0) {
                $user->dayLimit = 1;
                $user->save();
            }
        }
    }

    public function temporaryUnblock(Word $word) {
        if (User::find(1)->dayLimit === 1) {
            return \Redirect::back()->withErrors(['You have reached the limit of unblock attempts for today.']);
        }

        $CntOfDisabledBlockedWord = Word::where('disableFlg', 1)->count();

        if ($CntOfDisabledBlockedWord >= 3) {
            return \Redirect::back()->withErrors(['the number of blocking per day meets the limit.']);
        } elseif ($CntOfDisabledBlockedWord <= 2 && $CntOfDisabledBlockedWord >= 0) {
            $word->disableFlg += 1;
            $word->save();
            if ($CntOfDisabledBlockedWord === 0) {
                $user = User::find(1);
                $user->timeLimit = Carbon::now()->addMinutes(30);
                $user->save();
            }
            return redirect()->back();
        } else {
            return \Redirect::back()->withErrors(['Something is wrong with the system']);
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
