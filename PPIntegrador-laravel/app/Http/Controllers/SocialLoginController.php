<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        // Solución temporal con stateless()
        $githubUser = Socialite::driver('github')->stateless()->user();

        $user = User::firstOrCreate(
          ['email' => $githubUser->getEmail()],
                [
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'password' => bcrypt('github_fake_password') // ← campo requerido
                ]
        );

        Auth::login($user);

        return redirect()->intended('/inicio');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // Solución temporal con stateless()
        $googleUser = Socialite::driver('google')->stateless()->user();

         $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt('google_fake_password') // ← campo requerido
            ]
);

        Auth::login($user);

        return redirect()->intended('/inicio');
    }
}
