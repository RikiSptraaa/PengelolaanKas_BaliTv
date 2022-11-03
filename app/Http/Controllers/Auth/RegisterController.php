<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/home');
        }

        return view('auth.register');
    }

    public function register()
    {
        dd('berhasil');
    }
}
