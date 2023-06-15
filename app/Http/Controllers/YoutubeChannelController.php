<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YoutubeChannel;

use Log;

class YoutubeChannelController extends Controller
{

    public function list() {

        $youtube_blackList = YoutubeChannel::all();
        return view('list')
            ->with([
                'youtube_blackList' => $youtube_blackList,
            ]);
    }

    public function register(Request $request) {

        $request->validate([
            'name' => 'unique:youtube_channels'
        ], [
            'name.unique' => 'This channel_name is already registered.'
        ]);


        YoutubeChannel::create([
           'name' => $request->channel_name
        ]);

        return redirect()->route('register-page');
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
        $data = YoutubeChannel::all();

        $handle = fopen('export.csv', 'w');

        foreach ($data as $row) {
            fputcsv($handle, $row->toArray(), ';');
        }

        fclose($handle);
    }

    public function export_block_word() {

    }

    public function download() {
        $path = public_path('dummy.txt');
        
        $fileName = 'youtubechannelname.txt';

        $data = fopen($path, "w");

        $channel_name_list = YoutubeChannel::all()->pluck('name');

        foreach($channel_name_list as $channel_name) {
            fwrite($data, $channel_name);
            fwrite($data, "\n");
        }
        fclose($data);

        return response()->download($path, $fileName, ['Content-Type: text/plain']);
    }
}
