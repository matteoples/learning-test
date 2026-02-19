<?php

namespace App\Listeners;

use App\Events\LessonDeleted;
use App\Services\GoogleAccountService;
use Illuminate\Support\Facades\Log;

class DeleteLessonFromGoogleCalendar
{

    public function handle(LessonDeleted $event): void
    {
        $lesson = $event->lesson;
        $user = $lesson->user;


        // Controlli preliminari
        if (!$user->google_token) {
            \Log::warning("Manca il google_access_token per utente {$user->id}");
            return;
        }

        if (!$user->google_refresh_token) {
            \Log::warning("Manca il google_refresh_token per utente {$user->id}");
            return;
        }

        if (!$user->google_calendar_id) {
            \Log::warning("Manca il google_calendar_id per utente {$user->id}");
            return;
        }

        if (!$lesson->google_event_id) {
            \Log::info("Lezione {$lesson->id} non ha google_event_id, niente da cancellare");
            return;
        }

        //dd("Listener invocato");


        // Inizializza il service
        $service = new GoogleAccountService($user);

        $service->deleteEvent($user->google_calendar_id, $lesson->google_event_id);

        // Rimuove l'ID dal DB
        $lesson->update([
            'google_event_id' => null
        ]);
    }
}
