<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Role;




class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
       /** @var \Laravel\Socialite\Contracts\Provider $socialiteDriver */
        if ($provider === 'google') {
            return Socialite::driver('google')
                ->stateless()
                ->with(['prompt' => 'select_account']) // forces account selection screen
                ->redirect();
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }


    public function callback($provider)
    {

        $socialUser = Socialite::driver($provider)->stateless()->user();
        $email = $socialUser->getEmail();

        if (!$email) {
            return redirect()->route('register')->withErrors(['email' => 'No email provided from ' . $provider]);
        }

        // Normalize email (optional but recommended)
        $email = strtolower(trim($email));

        // Check if user already exists
        $user = User::where('email', $email)->first();

        if ($user) {
            // ✅ Log the user in if they already exist
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Welcome back!');
        }

        try {
            $user = User::create([
                'email' => $email,
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'password' => bcrypt(uniqid()), // dummy password
            ]);

            // Attach default 'user' role
            $user->roles()->attach(Role::where('name', 'user')->first()->id);

            Auth::login($user);

            return redirect()->route('user.completeProfile')->with('success', 'Registration successful! Please complete your profile.');
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->route('register')->withErrors(['error' => 'User creation failed.']);
        }
    }


}
