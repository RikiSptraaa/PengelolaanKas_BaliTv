<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticateController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];


        if (Auth::Attempt($data)) {
            return redirect('home');
        } else {
            Session::flash('error', 'Username atau Password Salah');
            return redirect('/login');
        }
    }
}
