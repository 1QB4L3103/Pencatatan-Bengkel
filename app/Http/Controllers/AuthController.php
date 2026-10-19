<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses data login (Sesuai Flowchart: Cek Login Valid?)[cite: 1]
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Pengecekan Role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard'); // Ke Dashboard Bengkel Admin[cite: 1, 4]
            } else {
                return redirect()->intended('/home'); // Ke Halaman Utama Belanja User/E-Commerce (Masa Depan)
            }
        }

        // Jika gagal (Sesuai Flowchart: Tampilkan Pesan Error)[cite: 1]
        return back()->with('error', 'Username atau Password salah!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}