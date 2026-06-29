<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif (Auth::user()->isInstansi()) {
                return redirect()->intended('/instansi/dashboard');
            }
        }

        return view('auth.login');
    }

    /**
     * Proses otentikasi login.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard')
                    ->with('success', 'Selamat datang kembali Admin SPPG!');
            } elseif ($user->isInstansi()) {
                return redirect()->intended('/instansi/dashboard')
                    ->with('success', 'Selamat datang kembali di panel Instansi!');
            }
        }

        return back()->withErrors([
            'email' => 'Email dan Password tidak sesuai.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
