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
        $driver = Socialite::driver($provider)->user();

        if ($provider == 'google') {
            $user = User::updateOrCreate([
                'google_id' => $driver->id,
                'name' => $driver->name,
                'username' => $driver->user['given_name'],
                'email' => $driver->email,
                'user_image' => $driver->avatar
            ]);
        } else if ($provider == 'github') {

            $user = User::updateOrCreate([
                'github_id' => $driver->id,
                'name' => $driver->name,
                'username' => $driver->nickname,
                'email' => $driver->email,
                'user_image' => $driver->avatar
            ]);
        }

        Auth::login($user);

        return redirect('/dashboard');
        // dd($google_user);
    }
}
