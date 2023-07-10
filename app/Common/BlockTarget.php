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
        $modelPath = "App\Models\\" . $model;

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

        Log::debug($model);

        if ($model === "Word") {
            foreach ($uploadedData as $row) {
                $NameGenreArray = explode(', ', $row);
                Log::debug($NameGenreArray);

                if ($modelPath::where('name', $row)->count() > 0 || empty($row)) {
                    continue;
                }
                $ModelInstance = new $modelPath();
                $ModelInstance->name = $NameGenreArray[0];
                $ModelInstance->genre = $NameGenreArray[1];
                $ModelInstance->save();
                }
            // after inserting the dataset
        } else {
            foreach ($uploadedData as $row) {

                if ($model::where('name', $row)->count() > 0 || empty($row)) {
                    continue;
                }
                $youtubeChannels = new $modelPath();
                $youtubeChannels->name = $row;
                $youtubeChannels->save();
            }
        }

        // after inserting the dataset
        Storage::delete('public/txt' . $newTxtFileName);
    }

    public function download($model, $path) {
        $fileName = $model . '.txt';
        $modelPath = "App\Models\\" . $model;

        if ($model === "Word") {
            $name_lists = $modelPath::all()->pluck('genre', 'name');
            $data = fopen($path, "w");
            foreach($name_lists as $name => $genre) {
                fwrite($data, $name);
                fwrite($data, ", ");
                fwrite($data, $genre);
                fwrite($data, "\n");
            }
        } else {
            $name_lists = $modelPath::all()->pluck('name');
            $data = fopen($path, "w");
            foreach($name_lists as $name) {
                fwrite($data, $name);
                fwrite($data, "\n");
            }
        }
        fclose($data);
        return $fileName;
    }
}
