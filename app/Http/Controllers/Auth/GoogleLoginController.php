<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
    
            $user = User::where('email', $googleUser->email)->first();
    
            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => null,
                    'profile_photo' => $googleUser->avatar,
                    'role' => 'passenger',
                    'phone' => null,
                ]);
    
                Auth::login($user);
            }
    
            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}