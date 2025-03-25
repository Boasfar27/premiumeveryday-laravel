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
            Log::info('Redirecting to Google login...');
            return Socialite::driver('google')
                ->stateless()
                ->redirectUrl('http://localhost:8000/auth/google/callback')
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
                'has_error' => $request->has('error')
            ]);

            if ($request->has('error')) {
                Log::error('Google callback error from Google: ' . $request->input('error'));
                return redirect()->route('login')
                    ->with('error', 'Login dengan Google dibatalkan atau ditolak');
            }

            $googleUser = Socialite::driver('google')
                ->stateless()
                ->redirectUrl('http://localhost:8000/auth/google/callback')
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

            return redirect()->route('user.dashboard')
                ->with('success', 'Login dengan Google berhasil!');

        } catch (\Exception $e) {
            Log::error('Google callback error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi. Detail: ' . $e->getMessage());
        }
    }
} 