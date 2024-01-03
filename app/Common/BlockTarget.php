<?php

namespace App\Common;
use Log;
use Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Word;

class BlockTarget {
    /**
     * @param string $model
     * @return Collection
     */
    public function getModel(string $model) {
        $authenticated_user = Auth::user();
        $lists = $authenticated_user->$model;
        return $lists;
    }

    public function getCnt(string $model): int {
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
        $this->fileValidation($request);

        //ファイルの保存
        $newTxtFileName = $request->file('txtFile')->getClientOriginalName();
        $request->file('txtFile')->storeAs('public/txt', $newTxtFileName);
        $txtFile = Storage::disk('local')->get("public/txt/{$newTxtFileName}");
        // $txtファイルの中身からコレクション作成。explodeで改行ごとに分解
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
            $modifiedModel = ucfirst(substr($model, 0, -1)); //ex)sites -> Site
            //ex)Youtube_channel -> YoutubeChannel
            if (strpos($modifiedModel, '_') !== false) {
                $underscorePos = strpos($modifiedModel, '_');
                $modifiedModel = substr_replace($modifiedModel, strtoupper($modifiedModel[$underscorePos + 1]), $underscorePos + 1, 1);
                $modifiedModel = str_replace('_', '', $modifiedModel);
            }
            $modifiedModel = "App\Models\\" . $modifiedModel;
            foreach ($uploadedData as $row) {
                $row = str_replace("\r", "", $row);
                if ($authenticated_user->$model->where('name', $row)->count() > 0 || empty($row)) {
                    continue;
                }
                $ModelInstance = new $modifiedModel();
                $ModelInstance->name = $row;
                $ModelInstance->save();
                $authenticated_user->$model()->syncWithoutDetaching($ModelInstance->id);
            }
        }
        Storage::delete('public/txt' . $newTxtFileName);
    }

    public function fileValidation($request) {
        if ($request->hasFile('txtFile')) {
            // check if the extension of file is txt
            if ($request->txtFile->getClientOriginalExtension() !== "txt") {
                return \Redirect::back()->withErrors(['the extension of file must be .txt']);
            }
        } else {
            return \Redirect::back()->withErrors(['choose a imported file at above btn.']);
        }
    }

    public function export($model, $path, $flg = null) {
        $data = fopen($path, "w");
        $this->writingFile($model, $flg, $data);
        fclose($data);
        return $model . '.txt';
    }

    // write blocking data in file
    public function writingFile($model, $flg, $data) {
        if ($flg == 1) {
            $model = "sites";
        }
        // $name_lists = Auth::user()->$model()->orderBy('id', 'ASC')->get()->pluck('genre', 'name');
        $name_lists = Auth::user()->$model()->orderBy('id', 'ASC')->get();
        if ($model === "words") {
            foreach($name_lists as $name => $genre) {
                fwrite($data, $name);
                fwrite($data, ", ");
                fwrite($data, $genre);
                fwrite($data, "\n");
            }
        } elseif ($model === "sites" && $flg === 1) {
            foreach($name_lists as $name => $genre) {
                fwrite($data, "127.0.0.1 www.");
                fwrite($data, $name);
                fwrite($data, "\n");
            }
            foreach($name_lists as $name => $genre) {
                fwrite($data, "127.0.0.1 ");
                fwrite($data, $name);
                fwrite($data, "\n");
            }
        } else {
            foreach($name_lists as $name => $genre) {
                fwrite($data, $name);
                fwrite($data, "\n");
            }
        }
    }
}
