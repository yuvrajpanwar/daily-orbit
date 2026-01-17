<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class GoogleController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {

        // Save where the user was before going to Google
        session()->put('url.intended', url()->previous());

        // Optional: also let Laravel's default intended system know
        // redirect()->intended() will prefer this value if set
        redirect()->setIntendedUrl(url()->previous());

        return Socialite::driver('google')->redirect();
    }

    // Handle callback
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
    
        // Find existing user or prepare a new one
        $user = User::firstOrNew(['email' => $googleUser->getEmail()]);
    
        // If it's a brand-new user, assign password once
        if (! $user->exists) {
            $user->password = bcrypt(Str::random(16));
            $user->name      = $googleUser->getName();
            $user->avatar    = $googleUser->getAvatar();
            $user->google_id = $googleUser->getId();
            $user->profile_picture = $googleUser->user['picture'] ?? $googleUser->getAvatar(); // full-size
        }
    
        $user->email_verified_at = now();
        $user->save();
    
        Auth::login($user);
    
        return redirect()->intended(route('home'));
    }
    
}
