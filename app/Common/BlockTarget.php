<?php

namespace App\Common;
use Log;
use Storage;
use Illuminate\Support\Facades\Auth;
use App\Model\Word;

class BlockTarget {

    public function getModel($model) {
        $authenticated_user = Auth::user();
        // $lists = $authenticated_user->youtube_channels;
        $lists = $authenticated_user->$model;
        return $lists;
    }

    public function getCnt($model) {
        $authenticated_user = Auth::user();
        $cnt = $authenticated_user->$model->count();
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
        $authenticated_user = Auth::user();

        if ($request->hasFile('txtFile')) {
            // check if the extension of file is txt
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

        // $txtを元に行単位のコレクション作成。explodeで改行ごとに分解
        $uploadedData = collect(explode("\n", $txtFile));

        if ($model === "words") {
            foreach ($uploadedData as $row) {
                $NameGenreArray = explode(', ', $row);
                if ($authenticated_user->$model->where('name', $row)->count() > 0 || empty($row)) {
                    continue;
                }
                $ModelInstance = new Word();
                $ModelInstance->name = $NameGenreArray[0];
                $ModelInstance->genre = $NameGenreArray[1];
                $ModelInstance->save();
                $authenticated_user->words()->syncWithoutDetaching($ModelInstance->id);
            }

        } else {
            foreach ($uploadedData as $row) {
                Log::debug($row);
                if ($authenticated_user->$model->where('name', $row)->count() > 0 || empty($row)) {
                    continue;
                }
                $modifiedModel = ucfirst(substr($model, 0, -1)); //ex)sites -> Site
                //ex)Youtube_channel -> YoutubeChannel
                if (strpos($modifiedModel, '_') !== false) {
                    $underscorePos = strpos($modifiedModel, '_');

                    $modifiedModel = substr_replace($modifiedModel, strtoupper($modifiedModel[$underscorePos + 1]), $underscorePos + 1, 1);
                    $modifiedModel = str_replace('_', '', $modifiedModel);
                }
                $modifiedModel = "App\Models\\" . $modifiedModel;

                $ModelInstance = new $modifiedModel();
                $ModelInstance->name = $row;
                $ModelInstance->save();
                $authenticated_user->$model()->syncWithoutDetaching($ModelInstance->id);

            }
        }
        Storage::delete('public/txt' . $newTxtFileName);
    }

    public function download($model, $path) {
        $fileName = $model . '.txt';
        $authenticated_user = Auth::user();
        if ($model === "words") {
            $name_lists = $authenticated_user->$model->pluck('genre', 'name');
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
