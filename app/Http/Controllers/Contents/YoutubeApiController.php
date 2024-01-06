<?php

namespace App\Http\Controllers\Contents;

use Illuminate\Http\Request;
use App\Models\YoutubeApi;

class YoutubeApiController extends Controller
{
    public function register(Request $request) {

        if (YoutubeApi::all()->count() >= 1) {
            return \Redirect::back()->withErrors(['API is already registered.']);
        }

        $api = new YoutubeApi();
        $api->key = $request->name;
        $api->save();

        return redirect()->route('content-page');
    }
}
