<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            return $this->redirectBasedOnRole();
        }

        return redirect()->back()->with('error', 'Authentication failed. Please verify your credentials.');
    }

    private function redirectBasedOnRole()
    {
        if (Auth::user()->role === 'manager') {
            return redirect()->route('manager.dashboard')->with('success','Welcome back, ' . Auth::user()->name);
        }
        
        if (Auth::user()->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        }
        
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Default untuk staff
        return redirect()->route('staff.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}