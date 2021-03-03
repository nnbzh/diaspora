<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('Auth.login');
    }

    public function authenticate(Request $request){
        if(Auth::attempt(['username' => $request['login'], 'password' => $request['password'], 'role_id' => 1])){
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors('Ошибка! Введите правельный логин или пароль!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('AdminLogin'));
    }
}
