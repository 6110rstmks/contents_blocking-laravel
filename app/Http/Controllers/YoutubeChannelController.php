<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YoutubeChannel;
use App\Models\YoutubeApi;
use App\Imports\YoutubeChannelsImport;
use Exception;
use Storage;
use App\Common\BlockTarget;
use Log;


class YoutubeChannelController extends Controller
{

    protected $blockTarget;

    public function __construct(BlockTarget $blockTarget) {
        $this->blockTarget = $blockTarget;
    }

    public function list() {
        $lists = $this->blockTarget->getModel("YoutubeChannel");

        $cnt = $this->blockTarget->getCnt("YoutubeChannel");
        $return_file = 'youtube-list';
        return view($return_file)
            ->with([
                'lists' => $lists,
                'cnt' => $cnt,
                'filename' => "youtube"
            ]);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|unique:youtube_channels'
        ]);

        $channelName = ltrim($request->name);

        if (strpos($channelName, '　') !== false || strpos($channelName, ' ') !== false) {
            return \Redirect::back()->withErrors(['Don\'t put spaces between words']);
        }

        YoutubeChannel::create([
           'name' => $channelName
        ]);

        return redirect()->route('register-page');
    }

    public function block(Request $request) {
        $videoID = $request->input('videoid');

        $channel_name = $this->getChannelName($videoID);
        if (YoutubeChannel::where('name', $channel_name)->count() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getChannelName($videoID) {
        $API_KEY =  YoutubeApi::first()->key;
        Log::debug($API_KEY);
        $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=" . $videoID . "&key=" . $API_KEY;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);

        $data2 = json_decode($data, true);

        $items = $data2['items'][0];

        $data3 = $items["snippet"];
        return $data3["channelTitle"];
    }

    // imported files is must be txt file.
    public function import(Request $request) {
        $this->blockTarget->import("YoutubeChannel", $request);
        return redirect()->back();
    }

    public function download() {
        $path = public_path('/storage/dummy.txt');
        $fileName = $this->blockTarget->download("YoutubeChannel", $path);
        return response()->download($path, $fileName, ['Content-Type: text/plain']);
    }
}
