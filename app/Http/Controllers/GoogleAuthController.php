<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        try {
            Log::info('Redirecting to Google login...', [
                'redirect_url' => config('services.google.redirect'),
                'client_id' => config('services.google.client_id')
            ]);
            
            return Socialite::driver('google')
                ->stateless()
                ->redirectUrl(config('services.google.redirect'))
                ->redirect();
        } catch (\Exception $e) {
            Log::error('Google redirect error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            // Log the request for debugging
            Log::info('Google callback request received', [
                'url' => $request->fullUrl(),
                'has_code' => $request->has('code'),
                'has_error' => $request->has('error'),
                'redirect_url' => config('services.google.redirect'),
                'client_id' => config('services.google.client_id'),
                'client_secret_length' => strlen(config('services.google.client_secret'))
            ]);

            if ($request->has('error')) {
                Log::error('Google callback error from Google: ' . $request->input('error'));
                return redirect()->route('login')
                    ->with('error', 'Login dengan Google dibatalkan atau ditolak');
            }

            $googleUser = Socialite::driver('google')
                ->stateless()
                ->redirectUrl(config('services.google.redirect'))
                ->user();
            
            Log::info('Google user data received', [
                'id' => $googleUser->id,
                'email' => $googleUser->email,
                'name' => $googleUser->name
            ]);
            
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                Log::info('Creating new user from Google login', ['email' => $googleUser->email]);
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
                Log::info('Updating existing user from Google login', ['email' => $googleUser->email, 'id' => $user->id]);
                $user->update([
                    'google_id' => $googleUser->id,
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user);
            Log::info('User logged in successfully via Google', ['user_id' => $user->id]);

            if ($user->role == 1) {
                return redirect('/admin/login');
            }

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
            Log::error('Google callback error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }
} 