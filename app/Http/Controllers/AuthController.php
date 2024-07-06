<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //login
    public function loginProcess(Request $request)
    {
        // Validate form data including reCAPTCHA
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect('/dashboard')->with('success', 'Welcome ' . $user->name . '!');
            } else {
                Auth::logout();
                return redirect('/')->with('error', 'Maaf, Halaman tidak ditemukan!');
            }
        } else {
            return redirect('/')->with('error', 'Maaf, Email atau Password salah!');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
