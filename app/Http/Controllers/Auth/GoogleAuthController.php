<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $google_user = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'google_id' => $google_user->id,
            'name' => $google_user->name,
            'username' => $google_user->user['given_name'],
            'email' => $google_user->email,
            'user_image' => $google_user->avatar
        ]);

        Auth::login($user);

        return redirect('/dashboard');
        // dd($google_user);
    }
}
