<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/home');
        }

        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'unique:users,username|required',
            'password' => 'required_with:password_confirmation|same:password_confirmation|required|min:6',
            'password_confirmation' => 'required|min:6'
        ]);


        // dd(Hash::make($request->password));

        // dd($request->all());

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect('login')->with('succes', 'login berhasil!');
    }
}
