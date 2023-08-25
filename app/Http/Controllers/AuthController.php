<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    //

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $fecha = Carbon::now();
        $userGoogle = Socialite::driver('google')->user();
        // dd($userGoogle);

        $user = User::updateOrCreate([
            'google_id' => $userGoogle->id,
        ], [
            'name' => $userGoogle->name,
            'email' => $userGoogle->email,
            'email_verified_at' => $fecha,
            'google_id' => $userGoogle->id,
            'google_token' => $userGoogle->token,
            'google_refresh_token' => $userGoogle->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
