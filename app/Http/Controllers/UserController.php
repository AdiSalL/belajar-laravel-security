<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function login(Request $request) {
        $response = Auth::attempt([
            "email" => $request->get("email", "wrong"),
            "password" => $request->get("password", "wrong"),
        ]);
        if($response) {
            $request->session()->regenerate();
            return redirect("/users/current");
        }else {
            return response()->json(["error" => "Invalid credentials"], 401);

        }
    }

    public function  current() {
        $user = Auth::user();
        if($user) {
            return "Hello $user->name";
        }else {
            return 'Hello Guest';
        }
    }


}
