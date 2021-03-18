<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->level_role == 'admin') {
                return redirect('admin');
            } else {
                return redirect('dokter');
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {

        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credensil = $request->only('email', 'password');
        if (Auth::attempt($credensil)) {
            $user = Auth::user();
            if ($user->level_role = 'admin') {
                return redirect()->intended('admin');
            } else if ($user->level_role = 'dokter') {
                return redirect()->intended('dokter');
            } else {
                return redirect()->intended('/');
            }
        }
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('login');
    }
}
