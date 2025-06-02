<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle a login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Cari user berdasarkan username atau email
        $user = User::where('username', $credentials['username'])
                    ->orWhere('email', $credentials['username'])
                    ->first();

        // Periksa apakah user ada & password benar
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        // Login user
        Auth::login($user);

        // Arahkan sesuai role
        return $this->handleUserRedirect();
    }

    /**
     * Redirect user based on their role after login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleUserRedirect()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'ukm':
                return redirect()->route('ukm.dashboard');
            case 'mahasiswa':
                return redirect()->route('mahasiswa.dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }
}