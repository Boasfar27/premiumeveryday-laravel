<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return view('pages.user.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        
        $user->update($request->validated());

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }
} 