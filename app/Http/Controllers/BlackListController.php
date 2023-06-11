<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YoutubeChannel;

use Log;

class BlackListController extends Controller
{
    public function register(Request $request) {
        YoutubeChannel::create([
           'name' => $request->channel_name
        ]);

        return view('register');
    }

    public function channel_block(Request $request) {
        $videoID = $request->input('videoid');
        $API_KEY = "AIzaSyBNTsy_ilAP1XecHoqTu3CK_23-25G05eU";
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
        $channel_name = $data3["channelTitle"];

        if (YoutubeChannel::where('name', $channel_name)->count() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function export_channel_name() {

    }

    public function export_block_word() {
        
    }
}
