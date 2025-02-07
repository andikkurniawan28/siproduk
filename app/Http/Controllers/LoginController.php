<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function process(Request $request){
        $attempt = Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($attempt)
        {
            $request->session()->regenerate();
            return redirect()->intended();
        }
        else
        {
            return redirect('login')->with('error', 'Username / password salah!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
