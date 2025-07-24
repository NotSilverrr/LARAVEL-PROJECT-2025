<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the OAuth Provider.
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider and login/register.
     */
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error('Socialite error: ' . $e->getMessage());
            return redirect('/login')->withErrors(['socialite' => 'Erreur de connexion avec ' . $provider]);
        }

        $user = User::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        if (!$user) {
            // Try to find by email
            $user = User::where('email', $socialUser->getEmail())->first();
            if ($user) {
                $user->provider_id = $socialUser->getId();
                $user->provider_name = $provider;
                $user->save();
            } else {
                // Create a new user
                $fullName = $socialUser->getName() ?? $socialUser->getNickname() ?? $socialUser->getEmail();
                $firstname = $fullName;
                $lastname = '';

                // Si le nom complet contient un espace, on sépare prénom/nom
                if (strpos($fullName, ' ') !== false) {
                    $parts = explode(' ', $fullName, 2);
                    $firstname = $parts[0];
                    $lastname = $parts[1];
                }

                $username = '';
                if (!empty($firstname) && !empty($lastname)) {
                    $username = Str::slug($firstname . '.' . $lastname);
                } elseif (!empty($firstname)) {
                    $username = Str::slug($firstname);
                } elseif ($socialUser->getEmail()) {
                    $username = strstr($socialUser->getEmail(), '@', true);
                } else {
                    $username = 'user-' . Str::random(6);
                }
                // Si username est vide, fallback sur l'email
                if (empty($username)) {
                    $username = $socialUser->getEmail();
                }
                // Vérifie l'unicité du username
                $baseUsername = $username;
                $suffix = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $baseUsername . '-' . $suffix;
                    $suffix++;
                }

                $user = User::create([
                    'name' => $fullName,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'username' => $username,
                    'email' => $socialUser->getEmail(),
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                    'password' => bcrypt(Str::random(24)),
                ]);
            }
        }

        Auth::login($user, true);
        return redirect()->intended('/dashboard');
    }
}
