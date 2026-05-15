<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ===================== AUTH ROUTES =====================
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required',
    ]);

    // Admin password case-insensitive
    if (strtolower($credentials['username']) === 'admin') {
        $credentials['password'] = strtolower($credentials['password']);
    }

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
})->name('login.post');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// ===================== PROTECTED ROUTES =====================
Route::middleware(['auth'])->group(function () {

    // Dashboard utama
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Monitoring pasien aktif
    Route::get('/monitoring', function () {
        return view('patients.monitoring');
    })->name('monitoring');

    // Filter overstay
    Route::get('/overstay', function () {
        return view('patients.overstay');
    })->name('overstay');

    // Riwayat pasien
    Route::get('/riwayat', function () {
        return view('patients.history');
    })->name('history');

    // Halaman Manajemen Pengguna (Khusus Admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', function () {
            return view('users.index');
        })->name('users.index');
    });

    // Profile sederhana
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});
