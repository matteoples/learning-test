<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GoogleAccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new \Google\Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('auth.callback'));
        
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes([
            'openid',
            'profile',
            'email',
            'https://www.googleapis.com/auth/calendar',
        ]);

        return redirect($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new \Google\Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('auth.callback'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes([
            'openid',
            'profile',
            'email',
            \Google\Service\Calendar::CALENDAR,
        ]);

        $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

        if (isset($token['error'])) {
            dd('Errore durante OAuth: ', $token);
        }

        $client->setAccessToken($token);

        $oauth = new \Google\Service\Oauth2($client);
        $googleUser = $oauth->userinfo->get();

        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_token' => $token['access_token'],
            'google_refresh_token' => $token['refresh_token'] ?? null,
        ]);

        Auth::login($user);

        if (!$user->google_calendar_id) {
            $googleService = new GoogleAccountService($user);
            $calendarId = $googleService->createCalendar('Ripetiflow');
            $user->update(['google_calendar_id' => $calendarId]);
        }

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function reconnectGoogle()
    {
        $client = new \Google\Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('auth.callback'));
        
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes([
            'openid',
            'profile',
            'email',
            'https://www.googleapis.com/auth/calendar',
        ]);

        return redirect($client->createAuthUrl());
    }
}
