<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider(string $provider = 'google')
    {
        return Socialite::driver($provider)
            ->with(['prompt' => 'login'])
            ->stateless()
            ->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        $socialiteUser = Socialite::driver($provider)->stateless()->user();
        $user = User::query()->updateOrCreate([
            'email' => $socialiteUser->email,
        ], [
            'email' => $socialiteUser->email,
            'name' => $socialiteUser->name,
            'password' => Str::random(),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return view('home');
    }
}
