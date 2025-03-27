<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;

class AuthController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'verify', 'showVerification', 'resendVerification']);
        $this->middleware('auth')->only(['verify', 'showVerification', 'resendVerification']);
    }

    public function showLogin()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.auth.mobile.login' : 
            'pages.auth.desktop.login'
        );
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.',
                ]);
            }

            if (!$user->email_verified_at && !$user->google_id) {
                return redirect()->route('verification.notice');
            }

            $request->session()->regenerate();

            if ($user->role === 1) {
                return redirect('/admin');
            }

            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    public function showRegister()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.auth.mobile.register' : 
            'pages.auth.desktop.register'
        );
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => '08' . $request->phone,
            'role' => 0,
            'is_active' => true,
            'verification_code' => sprintf("%06d", mt_rand(1, 999999))
        ]);

        // Kirim email verifikasi
        Mail::send('emails.verification', ['user' => $user], function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verifikasi Email - Premium Everyday');
        });

        Auth::login($user);

        return redirect()->route('verification.notice')
                        ->with('success', 'Pendaftaran berhasil! Silakan verifikasi email Anda.');
    }

    public function showVerification()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->email_verified_at) {
            return redirect()->route('user.dashboard');
        }

        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.auth.mobile.verify' : 
            'pages.auth.desktop.verify'
        );
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if ($user->verification_code !== $request->verification_code) {
            return back()->withErrors([
                'verification_code' => 'Kode verifikasi tidak valid.',
            ]);
        }

        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();

        return redirect()->route('user.dashboard')
                        ->with('success', 'Email berhasil diverifikasi!');
    }

    public function resendVerification()
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return redirect()->route('user.dashboard');
        }

        // Generate kode baru
        $user->verification_code = sprintf("%06d", mt_rand(1, 999999));
        $user->save();

        // Kirim ulang email
        Mail::send('emails.verification', ['user' => $user], function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verifikasi Email - Premium Everyday');
        });

        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->user();
            
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(24)),
                    'role' => 0,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            } else {
                $user->update([
                    'google_id' => $googleUser->id,
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user);

            return redirect()->route('home')->with('swal', [
                'icon' => 'success',
                'title' => 'Selamat Datang! 🛍️',
                'html' => '
                    <div class="text-center">
                        <div class="mb-4">
                            <svg class="mx-auto h-12 w-12 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="text-lg">Hai <strong>' . $user->name . '</strong>!</p>
                        <p>Silahkan belanja produk digital di Premium Everyday</p>
                    </div>
                ',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Mulai Belanja',
                'confirmButtonColor' => '#EC4899',
                'timer' => 5000,
                'timerProgressBar' => true,
            ]);

        } catch (\Exception $e) {
            return redirect()->route('login')
                            ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showForgotPassword()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.auth.mobile.forgot-password' : 
            'pages.auth.desktop.forgot-password'
        );
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        \DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        Mail::send('emails.reset-password', ['token' => $token], function($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Password - Premium Everyday');
        });

        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }

    public function showResetPassword($token)
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 
            'pages.auth.mobile.reset-password' : 
            'pages.auth.desktop.reset-password', 
            ['token' => $token]
        );
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $updatePassword = \DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

        if (!$updatePassword) {
            return back()->withErrors(['email' => 'Token tidak valid!']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        \DB::table('password_reset_tokens')
            ->where(['email' => $request->email])->delete();

        return redirect()->route('login')
                        ->with('success', 'Password berhasil diubah!');
    }
}
