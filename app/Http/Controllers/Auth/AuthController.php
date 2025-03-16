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
                        <p class="text-lg">Hai <strong>' . auth()->user()->name . '</strong>!</p>
                        <p>Silahkan belanja produk digital di Premium Everyday</p>
                    </div>
                ',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Mulai Belanja',
                'confirmButtonColor' => '#EC4899',
                'timer' => 5000,
                'timerProgressBar' => true,
            ]);
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
            
            return redirect()->route('home')->with('swal', [
                'icon' => 'success',
                'title' => 'Selamat Bergabung! 🎉',
                'html' => '
                    <div class="text-center">
                        <div class="mb-4">
                            <lottie-player
                                src="https://assets2.lottiefiles.com/packages/lf20_s2lryxtd.json"
                                background="transparent"
                                speed="1"
                                style="width: 200px; height: 200px; margin: 0 auto;"
                                autoplay
                            ></lottie-player>
                        </div>
                        <p class="text-lg mb-2">Hai <strong>' . $request->name . '</strong>!</p>
                        <p class="mb-4">Akun Anda berhasil dibuat</p>
                        <div class="bg-pink-50 p-4 rounded-lg mb-4">
                            <p class="text-pink-600">
                                <i class="fas fa-envelope mr-2"></i>
                                Silakan cek email Anda di:
                            </p>
                            <p class="font-semibold text-pink-700">' . $request->email . '</p>
                        </div>
                        <p class="text-sm text-gray-600">
                            Kami telah mengirimkan link verifikasi ke email Anda
                        </p>
                    </div>
                ',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Saya Mengerti',
                'confirmButtonColor' => '#EC4899',
                'showCancelButton' => true,
                'cancelButtonText' => 'Kirim Ulang Email',
                'cancelButtonColor' => '#9CA3AF',
                'allowOutsideClick' => false,
                'customClass' => [
                    'container' => 'registration-swal-container',
                    'popup' => 'registration-swal-popup',
                    'header' => 'registration-swal-header',
                    'content' => 'registration-swal-content',
                    'actions' => 'registration-swal-actions',
                ],
                'didOpen' => "(toast) => {
                    const content = toast.querySelector('.swal2-html-container');
                    if (content) {
                        const script = document.createElement('script');
                        script.src = 'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js';
                        document.head.appendChild(script);
                    }
                }"
            ]);
                
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
            return redirect()->route('home')->with('swal', [
                'icon' => 'info',
                'title' => 'Email Sudah Terverifikasi',
                'html' => '
                    <div class="text-center">
                        <div class="mb-4">
                            <lottie-player
                                src="https://assets5.lottiefiles.com/packages/lf20_Tkwjw8.json"
                                background="transparent"
                                speed="1"
                                style="width: 200px; height: 200px; margin: 0 auto;"
                                autoplay
                            ></lottie-player>
                        </div>
                        <p class="text-lg mb-2">Email Anda sudah diverifikasi sebelumnya</p>
                        <p class="text-sm text-gray-600">
                            Silakan lanjutkan berbelanja di Premium Everyday
                        </p>
                    </div>
                ',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Mulai Belanja',
                'confirmButtonColor' => '#EC4899',
                'allowOutsideClick' => false,
                'customClass' => [
                    'container' => 'registration-swal-container',
                    'popup' => 'registration-swal-popup',
                    'header' => 'registration-swal-header',
                    'content' => 'registration-swal-content',
                    'actions' => 'registration-swal-actions',
                ],
                'didOpen' => "(toast) => {
                    const content = toast.querySelector('.swal2-html-container');
                    if (content) {
                        const script = document.createElement('script');
                        script.src = 'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js';
                        document.head.appendChild(script);
                    }
                }"
            ]);
        }

        $user->markEmailAsVerified();
        $user->verification_code = null;
        $user->save();

        return redirect()->route('home')->with('swal', [
            'icon' => 'success',
            'title' => 'Email Berhasil Diverifikasi! 🎉',
            'html' => '
                <div class="text-center">
                    <div class="mb-4">
                        <lottie-player
                            src="https://assets3.lottiefiles.com/packages/lf20_Zw8DvW.json"
                            background="transparent"
                            speed="1"
                            style="width: 200px; height: 200px; margin: 0 auto;"
                            autoplay
                        ></lottie-player>
                    </div>
                    <p class="text-lg mb-2">Selamat <strong>' . $user->name . '</strong>!</p>
                    <p class="mb-4">Email Anda telah berhasil diverifikasi</p>
                    <div class="bg-green-50 p-4 rounded-lg mb-4">
                        <p class="text-green-600">  
                            <i class="fas fa-check-circle mr-2"></i>
                            Akun Anda sudah aktif
                        </p>
                    </div>
                    <p class="text-sm text-gray-600">
                        Silakan mulai berbelanja di Premium Everyday
                    </p>
                </div>
            ',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Mulai Belanja',
            'confirmButtonColor' => '#EC4899',
            'allowOutsideClick' => false,
            'customClass' => [
                'container' => 'registration-swal-container',
                'popup' => 'registration-swal-popup',
                'header' => 'registration-swal-header',
                'content' => 'registration-swal-content',
                'actions' => 'registration-swal-actions',
            ],
            'didOpen' => "(toast) => {
                const content = toast.querySelector('.swal2-html-container');
                if (content) {
                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js';
                    document.head.appendChild(script);
                }
            }"
        ]);
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