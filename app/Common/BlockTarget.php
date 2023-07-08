<?php

namespace App\Common;
use Log;
use Storage;

class BlockTarget {

    public function getModel($model) {

        $model = "App\Models\\" . $model;
        $lists =  $model::all();

        return $lists;
    }

    public function getCnt($model) {
        $model = "App\Models\\" . $model;
        $cnt = $model::all()->count();
        return $cnt;
    }

    public function register($model) {
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

    public function import($model, $request) {
        $model = "App\Models\\" . $model;

        if ($request->hasFile('txtFile')) {
            //拡張子がCSVであるかの確認
            if ($request->txtFile->getClientOriginalExtension() !== "txt") {
            return \Redirect::back()->withErrors(['不適切な拡張子です。']);

            }
            //ファイルの保存
            $newTxtFileName = $request->file('txtFile')->getClientOriginalName();
            $request->file('txtFile')->storeAs('public/txt', $newTxtFileName);
        } else {
            return \Redirect::back()->withErrors(['txtファイルの取得に失敗しました。']);
        }

        $txtFile = Storage::disk('local')->get("public/txt/{$newTxtFileName}");
        // $csvを元に行単位のコレクション作成。explodeで改行ごとに分解
        $uploadedData = collect(explode("\n", $txtFile));

        foreach ($uploadedData as $row) {

            if ($model::where('name', $row)->count() > 0 || empty($row)) {
                continue;
            }
            $youtubeChannels = new $model();
            $youtubeChannels->name = $row;
            $youtubeChannels->save();
        }
        // after inserting the dataset
        Storage::delete('public/txt' . $newTxtFileName);
    }

    public function download($model, $path) {
        $fileName = $model . '.txt';
        $data = fopen($path, "w");
        $model = "App\Models\\" . $model;
        $name_lists = $model::all()->pluck('name');
        foreach($name_lists as $name) {
            fwrite($data, $name);
            fwrite($data, "\n");
        }
        fclose($data);
        return $fileName;
    }
}
