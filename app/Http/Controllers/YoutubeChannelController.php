<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YoutubeChannel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YoutubeChannelsImport;
use Exception;
use Storage;
use App\Common\BlockTarget;



use Log;

class YoutubeChannelController extends Controller
{

    protected $blocktarget;

    public function __construct(BlockTarget $blocktarget) {
        $this->blockTarget = $blocktarget;
    }

    public function list() {
        $lists = $this->blockTarget->getModel("YoutubeChannel");

        $return_file = 'youtube-list';
        return view($return_file)
            ->with([
                'lists' => $lists,
            ]);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|unique:youtube_channels'
        ]);

        YoutubeChannel::create([
           'name' => $request->name
        ]);

        return redirect()->route('register-page');
    }

    public function block(Request $request) {
        $videoID = $request->input('videoid');

        $channel_name = getChannelName($videoID);
        if (YoutubeChannel::where('name', $channel_name)->count() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function getChannelName($videoID) {
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
        return $data3["channelTitle"];
    }

    // imported files is must be txt file.
    public function import(Request $request) {

        if ($request->hasFile('txtFile')) {
            //拡張子がCSVであるかの確認
            if ($request->txtFile->getClientOriginalExtension() !== "txt") {
                throw new Exception('不適切な拡張子です。');
            }
            //ファイルの保存
            $newTxtFileName = $request->file('txtFile')->getClientOriginalName();
            $request->file('txtFile')->storeAs('public/txt', $newTxtFileName);
        } else {
            throw new Exception('txtファイルの取得に失敗しました。');
        }

        $txtFile = Storage::disk('local')->get("public/txt/{$newTxtFileName}");
        // $csvを元に行単位のコレクション作成。explodeで改行ごとに分解
        $uploadedData = collect(explode("\n", $txtFile));

        foreach ($uploadedData as $row) {

            if (YoutubeChannel::where('name', $row)->count() > 0 || empty($row)) {
                continue;
            }
            $youtubeChannels = new YoutubeChannel();
            $youtubeChannels->name = $row;
            $youtubeChannels->save();
        }

        // after inserting the dataset
        Storage::delete('public/txt' . $newTxtFileName);


        return redirect()->action([YoutubeChannelController::class, 'list']);

    }

    public function download() {
        $path = public_path('dummy.txt');

        $fileName = 'youtubeChannelName.txt';

        $data = fopen($path, "w");

        $name_lists = YoutubeChannel::all()->pluck('name');

        foreach($name_lists as $name) {
            fwrite($data, $name);
            fwrite($data, "\n");
        }
        fclose($data);

        return response()->download($path, $fileName, ['Content-Type: text/plain']);
    }
}
