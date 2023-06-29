<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $blockTarget;

    public function __construct(BlockTarget $blockTarget) {
        $this->blockTarget = $blockTarget;
    }

    public function list() {
        $site_blackList = Site::all();
        $cnt = $this->blockTarget->getCnt("YoutubeChannel");

        return view('word-list')
            ->with([
                'word_blackList' => $word_blackList,
            ]);
    }

    public function register() {
        $request->validate([
            'name' => 'required|unique:sites'
        ]);

        $blockSite = ltrim($request->name);

        if (strpos($blockSite, '　') !== false || strpos($blockSite, ' ') !== false) {
            return \Redirect::back()->withErrors(['Don\'t put spaces between words']);
        }
        Word::create([
           'name' => $blockSite,
        ]);

        return redirect()->route('register-page');
    }

    public function block() {
        $url = $request->input('title');
        $url = preg_replace( "#^[^:/.]*[:/]+#i", "", $url );
        if (Site::where('name', $url)->count() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function import(Request $request) {
        $this->blockTarget->import("Site", $request);
        return redirect()->back();
    }

    public function download() {
        $path = public_path('dummy.txt');
        $fileName = $this->blockTarget->download("Site", $path);
        return response()->download($path, $fileName, ['Content-Type: text/plain']);
    }
}
