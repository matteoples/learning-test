<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;

class GoogleAccountService
{
    protected User $user;
    protected Google_Client $client;
    protected Google_Service_Calendar $calendarService;

    public function __construct(User $user)
    {
        $this->user = $user;

        // Inizializza Google Client
        $this->client = new Google_Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setAccessToken([
            'access_token' => $user->google_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in' => $user->google_token_expires_at
                ? now()->diffInSeconds($user->google_token_expires_at, false)
                : 3600
        ]);

        $this->refreshTokenIfNeeded();

        $this->calendarService = new Google_Service_Calendar($this->client);
    }

    /**
     * Gestione automatico refresh token
     */
    protected function refreshTokenIfNeeded(): void
    {
        if ($this->client->isAccessTokenExpired() && $this->user->google_refresh_token) {
            $newToken = $this->client->fetchAccessTokenWithRefreshToken(
                $this->user->google_refresh_token
            );

            $this->user->update([
                'google_token' => $newToken['access_token'],
                'google_token_expires_at' => now()->addSeconds($newToken['expires_in']),
            ]);

            $this->client->setAccessToken($newToken);
        }
    }

    /**
     * Callback OAuth - salva i token e crea il calendario se necessario
     */
    public function handleOAuthCallback($googleUser): User
    {
        $this->user->update([
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken ?? $this->user->google_refresh_token,
            'google_token_expires_at' => now()->addSeconds($googleUser->expiresIn ?? 3600),
            'name' => $googleUser->name,
            'email' => $googleUser->email,
        ]);

        // Creazione immediata calendario Ripetiflow
        $this->createCalendarIfMissing();

        return $this->user;
    }

    /**
     * Creazione calendario Ripetiflow se non esiste
     */
    public function createCalendarIfMissing(): string
    {
        if ($this->user->google_calendar_id) {
            return $this->user->google_calendar_id;
        }

        $calendar = new Google_Service_Calendar_Calendar([
            'summary' => 'Ripetiflow',
            'timeZone' => 'Europe/Rome',
        ]);

        $created = $this->calendarService->calendars->insert($calendar);

        $this->user->update([
            'google_calendar_id' => $created->getId(),
        ]);

        return $created->getId();
    }

    /**
     * Restituisce l'ID del calendario
     */
    public function getCalendarId(): string
    {
        return $this->user->google_calendar_id ?? $this->createCalendarIfMissing();
    }
}
