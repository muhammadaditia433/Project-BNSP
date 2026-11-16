<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }

    public function register(Request $r)
    {
        $data = $r->validate([
            'name'     => 'required|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        User::create($data + ['role' => 'user']);

        return redirect()->route('login')->with('ok', 'Registrasi berhasil. Silakan login.');
    }

    public function showLogin() { return view('auth.login'); }

    public function login(Request $r)
    {
        $cred = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($cred, $r->boolean('remember'))) {
            $r->session()->regenerate();
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->intended(route('home'));
        }
        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('home');
    }
}
