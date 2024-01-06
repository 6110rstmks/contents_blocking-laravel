<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\User;
use App\Common\BlockTarget;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Jobs\DisableProcess;
use App\Http\Requests\CreateWordFormRequest;

class WordController extends Controller
{
    protected $blockTarget;

    public function __construct(BlockTarget $blockTarget) {
        $this->blockTarget = $blockTarget;
    }

    public function list() {
        $authenticated_user = Auth::user();
        $words = $authenticated_user->words;
        $lists1 = $words->where('genre', 1);
        $lists2 = $words->where('genre', 2);
        $lists3 = $words->where('genre', 3);
        $cnt = $this->blockTarget->getCnt("words");
        $nowTime = Carbon::now();
        $endTime = $authenticated_user->timeLimit;
        $this->timeComparison($nowTime, $authenticated_user);
        $interval = $nowTime->diffAsCarbonInterval($endTime, false);

        if ($interval->invert != 0) {
            $interval = null;
        }

        return view('Content_blocking/word-list')
            ->with([
                'lists1' => $lists1,
                'lists2' => $lists2,
                'lists3' => $lists3,
                'cnt' => $cnt,
                'diffTime'=> $interval
            ]);
    }

    public function register(CreateWordFormRequest $request) {
        $auth_user = Auth::user();
        $blockWord = ltrim($request->name);
        if (strpos($blockWord, '　') !== false || strpos($blockWord, ' ') !== false) {
            return \Redirect::back()->withErrors(['Don\'t put spaces between words']);
        }
        $word = Word::create($request->validated());
        $auth_user->words()->syncWithoutDetaching($word->id);
        return redirect()->route('content-page');
    }

    public function block(Request $request) {
        $now_time = Carbon::now();
        $first_user = User::first();

        if (is_null($first_user)) { // if user is not still registered, prevent error
            return;
        }
        // $this->timeComparison($nowTime, $user);
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

    // public function containsHiraganaAndKatakana($str) {
    //     // ひらがなまたはカタカナを含む正規表現
    //     $pattern = '/[\p{Hiragana}\p{Katakana}]+/u';

    //     // 正規表現にマッチするかどうかを確認
    //     return preg_match($pattern, $str) === 1;
    // }

    // public function isHiragana($str) {
    //     // ひらがなのみを含む正規表現
    //     $pattern = '/^[\p{Hiragana}\s]+$/u';

    //     // 正規表現にマッチするかどうかを確認
    //     return preg_match($pattern, $str) === 1;
    // }

    // public function isKatakana($str) {
    //     // カタカナのみを含む正規表現
    //     $pattern = '/^[\p{Katakana}\s]+$/u';

    //     // 正規表現にマッチするかどうかを確認
    //     return preg_match($pattern, $str) === 1;
    // }

    public function timeComparison($nowTime, $user) {
        if (is_null($user->timeLimit)) {
            return;
        }
        $endTime = $user->timeLimit;

        if (!is_null($endTime) && $nowTime->gte($endTime)) {
            Word::where('disableFlg', 1)->update(['disableFlg' => 0]);
            $user = User::find(1);
            if ($user->dayLimit === 0) {
                $user->dayLimit = 1;
                $user->save();
            }
            $user->timeLimit = null;
            $user->save();
        }
    }

    // unblock word of genre 1 for ** minutes
    public function unblock(Word $word) {
        DisableProcess::dispatch($word)->delay(now()->addMinutes(15));
        $word->disableFlg = 1;
        $word->save();
        return redirect()->back();
    }

    // release blocking of 'genre 2' words for thirty minutes
    // deprecated function
    public function temporaryUnblock(Word $word) {
        if (User::find(1)->dayLimit === 1) {
            return \Redirect::back()->withErrors(['You have reached the limit of unblock attempts for today.']);
        }

        $CntOfDisabledBlockedWord = Word::where('disableFlg', 1)->where('genre', 2)->count();

        if ($CntOfDisabledBlockedWord >= 3) {
            return \Redirect::back()->withErrors(['the number of blocking per day meets the limit.']);
        } elseif ($CntOfDisabledBlockedWord <= 2 && $CntOfDisabledBlockedWord >= 0) {
            $word->disableFlg = 1;
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
        $this->blockTarget->import("words", $request);
        return redirect()->back();
    }

    public function export() {
        $path = public_path('/storage/dummy.txt');
        $fileName = $this->blockTarget->export("words", $path);
        return response()->download($path, $fileName, ['Content-Type: text/plain']);
    }
}
