<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\BlockTarget;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Log;
use App\Http\Requests\CreateSiteFormRequest;

class SiteController extends Controller
{
    protected $blockTarget;

    public function __construct(BlockTarget $blockTarget) {
        $this->blockTarget = $blockTarget;
    }

    public function list() {
        $lists = $this->blockTarget->getModel("sites");
        $cnt = $this->blockTarget->getCnt("sites");
        return view('site-list')
            ->with([
                'lists' => $lists,
                'cnt' => $cnt,
                'filename' => "site"
            ]);
    }

    public function register(Request $request) {
        $auth_user = Auth::user();
        $blockSite = ltrim($request->name);
        if (strpos($blockSite, '　') !== false || strpos($blockSite, ' ') !== false) {
            return \Redirect::back()->withErrors(['Don\'t put spaces between words.']);
        }
        if (strpos($blockSite, '/') !== false || strpos($blockSite, '@') !== false) {
            return \Redirect::back()->withErrors(["Don't contain \"@\" or \"/\"."]);
        }
        $siteModel = new Site();
        $siteModel->name = $blockSite;
        $siteModel->save();
        $auth_user->sites()->syncWithoutDetaching($siteModel->id);
        return redirect()->route('register-page');
    }

    public function block(Request $request) {
        $url = $request->input('title');
        $url = preg_replace( "#^[^:/.]*[:/]+#i", "", $url );
        $urls_in_db = Site::all()->pluck("name");
        // $whiteListFlg = $this->whiteListCheck($url);
        // if ($whiteListFlg == 0) {
        //     return 0;
        // }
        if ($this->whiteListCheck($url)) {
            return 0;
        }
        foreach ($urls_in_db as $data) {
            if (strpos($url, $data) != false || strpos($url, $data) === 0) {
                return 1;
            }
        }
        return 0;
    }

    public function whiteListCheck($url) {
        $whiteList = ["detail.chiebukuro.yahoo.co.jp", "eikaiwa.dmm.com"];
        if (in_array($url, $whiteList)) {
            return true;
        }
    }

    public function import(Request $request) {
        $this->blockTarget->import("sites", $request);
        return redirect()->back();
    }

    public function export() {
        $path = public_path('/storage/dummy.txt');
        $fileName = $this->blockTarget->export("sites", $path);
        return response()->download($path, $fileName, ['Content-Type: text/plain']);
    }

    public function export_for_hostsfile() {
        $path = public_path('/storage/dummy.txt');
        $fileName = $this->blockTarget->export("sites_for_hosts", $path, 1);
        return response()->download($path, $fileName, ['Content-Type: text/plain']);
    }
}
