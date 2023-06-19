<?php

namespace App\Common;
use Log;

class BlockTarget {

    public function getModel($model) {

        $model = "App\Models\\" . $model; 
        $lists =  $model::all();

        return $lists;
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
}