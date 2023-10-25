<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;


class UserController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials))
        if (Auth::guard('web')->attempt($credentials, false))
        {

            // session hijacking countermeasure
            $request->session()->regenerate();
            return redirect()->route('register-page');

        } else {
            // 認証に失敗したら
            return back();
        }


    }
}
