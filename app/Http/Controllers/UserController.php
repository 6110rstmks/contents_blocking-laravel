<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;


class UserController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        Log::debug($credentials);
        if (Auth::attempt($credentials))
        {
            return redirect()->route('register-page');

        } else {
            // 認証に失敗したら
            return back();
        }


    }
}
