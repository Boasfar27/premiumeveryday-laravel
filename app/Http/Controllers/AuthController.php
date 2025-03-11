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
        return view($agent->isMobile() ? 'pages.mobile.auth.login' : 'pages.desktop.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        
        Log::info('Login attempt', [
            'email' => $request->email
        ]);
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            Log::info('User authenticated', [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'is_active' => $user->is_active ? 'Yes' : 'No',
                'email_verified' => $user->email_verified_at ? 'Yes' : 'No'
            ]);
            
            // Cek status aktif
            if (!$user->is_active) {
                Auth::logout();
                Log::warning('Inactive user attempted login', ['email' => $user->email]);
                return back()->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }

            // Cek verifikasi email
            if (!$user->email_verified_at) {
                Log::info('Unverified user redirected to verification', ['email' => $user->email]);
                return redirect()->route('verification.notice')
                    ->with('warning', 'Silakan verifikasi email Anda terlebih dahulu.');
            }

            $request->session()->regenerate();

            // Redirect berdasarkan role
            if ($user->role === 1) {
                Log::info('Admin login successful', ['email' => $user->email]);
                return redirect()->intended(route('admin.dashboard'));
            } else {
                Log::info('User login successful', ['email' => $user->email]);
                return redirect()->intended(route('user.dashboard'));
            }
        }

        Log::warning('Failed login attempt', ['email' => $request->email]);
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.mobile.auth.register' : 'pages.desktop.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $verificationCode = Str::random(6);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
            'role' => 0, // Default role untuk user biasa
            'is_active' => true
        ]);

        // Kirim email verifikasi
        Mail::send('emails.verification', ['code' => $verificationCode], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verifikasi Email Premium Everyday');
        });

        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Pendaftaran berhasil! Silakan verifikasi email Anda.');
    }

    public function showVerification()
    {
        if (auth()->check() && auth()->user()->email_verified_at) {
            return $this->redirectBasedOnRole(auth()->user());
        }

        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.mobile.auth.verify' : 'pages.desktop.auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        $user = User::where('verification_code', $request->verification_code)->first();

        if (!$user) {
            return back()->with('error', 'Kode verifikasi tidak valid.');
        }

        $user->update([
            'email_verified_at' => now(),
            'verification_code' => null,
        ]);

        if (!Auth::check()) {
            Auth::login($user);
        }

        return $this->redirectBasedOnRole($user)
            ->with('success', 'Email berhasil diverifikasi!');
    }

    public function resendVerification()
    {
        $user = Auth::user();
        
        if ($user->email_verified_at) {
            return $this->redirectBasedOnRole($user);
        }

        $verificationCode = Str::random(6);
        $user->update(['verification_code' => $verificationCode]);

        Mail::send('emails.verification', ['code' => $verificationCode], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verifikasi Email Premium Everyday');
        });

        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                // Cek apakah email sudah terdaftar
                $existingUser = User::where('email', $googleUser->email)->first();
                
                if ($existingUser) {
                    // Update google_id jika email sudah ada
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                        'is_active' => true,
                        'email_verified_at' => now(),
                    ]);
                    
                    Auth::login($existingUser);
                    return $this->redirectBasedOnRole($existingUser);
                }

                // Buat user baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role' => 0, // Default role untuk user biasa
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user);
            return $this->redirectBasedOnRole($user);

        } catch (\Exception $e) {
            Log::error('Google login error', ['error' => $e->getMessage()]);
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    protected function redirectBasedOnRole($user)
    {
        return $user->role === 1 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    // Password Reset Methods
    public function showForgotPassword()
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.mobile.auth.forgot-password' : 'pages.desktop.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(string $token)
    {
        $agent = new Agent();
        return view($agent->isMobile() ? 'pages.mobile.auth.reset-password' : 'pages.desktop.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
