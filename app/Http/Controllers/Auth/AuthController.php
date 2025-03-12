<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class AuthController extends Controller
{
    public function showLogin()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.auth.mobile.login' : 'pages.auth.desktop.login');
    }

    public function showRegister()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.auth.mobile.register' : 'pages.auth.desktop.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $verificationCode = Str::random(60);
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'verification_code' => $verificationCode,
            ]);

            Mail::to($user->email)->send(new VerificationEmail($user));
            
            Auth::login($user);
            
            return redirect()->route('home')
                ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
                
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => null,
                    'email_verified_at' => now(),
                ]);
            } else {
                $user->update([
                    'google_id' => $googleUser->id,
                    'email_verified_at' => now(),
                ]);
            }
            
            Auth::login($user);
            
            if ($user->role == 1) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('user.dashboard');
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Terjadi kesalahan saat login dengan Google.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function showVerification()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.auth.mobile.verify' : 'pages.auth.desktop.verify');
    }

    public function verify(Request $request, $code)
    {
        $user = User::where('verification_code', $code)->first();

        if (!$user) {
            return redirect()->route('verification.notice')
                ->withErrors(['error' => 'Kode verifikasi tidak valid.']);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')
                ->with('success', 'Email sudah diverifikasi sebelumnya.');
        }

        $user->markEmailAsVerified();
        $user->verification_code = null;
        $user->save();

        return redirect()->route('home')
            ->with('success', 'Email Anda berhasil diverifikasi.');
    }

    public function resendVerification(Request $request)
    {
        $user = $request->user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $user->verification_code = Str::random(60);
        $user->save();

        try {
            Mail::to($user->email)->send(new VerificationEmail($user));
            return back()->with('success', 'Link verifikasi baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim ulang email verifikasi: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal mengirim email verifikasi. Silakan coba lagi nanti.']);
        }
    }
} 