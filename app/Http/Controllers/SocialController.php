<?php

namespace App\Http\Controllers;


use Socialite;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    /**
     * Redirect the user to the provider's authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    /**
     * Obtain the user information from the provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect()->route('admin.login')->withErrors(['msg' => 'Login failed']);
        }

        
        // Find the user by email first
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Update provider info if not linked
            if (!$user->provider_id || $user->provider !== $provider) {
                $user->name=$socialUser->getName();
                $user->provider_id = $socialUser->getId();
                $user->provider = $provider;
                $user->save();
            }
        } else {
            // Create a new user with a dummy password
            $user = User::create([
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName(),
                'provider_id' => $socialUser->getId(),
                'provider' => $provider,
                'password' => bcrypt(Str::random(24)), // Generate a random password
            ]);
        }

        // Log the user in and remember them
        Auth::login($user, true); // true enables "remember me"

        return redirect()->route('events.index');
    }
}
