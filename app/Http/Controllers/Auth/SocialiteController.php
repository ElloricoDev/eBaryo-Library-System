<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirect () {
        return Socialite::driver('google')->redirect();
    }

    public function callback () {
        $googleUser = Socialite::driver('google')->user();

        $fullName = $googleUser->getName();
        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $user = User::where('email', $googleUser->getEmail())->first();
        if ($user) {
            Auth::login($user);
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Admin login successful');
            } else {
                return redirect()->route('home')->with('success', 'Login successful');
            }
        } else {
            $user = User::create([
                'user_name' => $fullName,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(10)),
            ]);
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Login successful');
        }
    }
}
