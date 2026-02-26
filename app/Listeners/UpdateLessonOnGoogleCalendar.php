<?php

namespace App\Listeners;

use App\Events\LessonUpdated;
use App\Services\GoogleAccountService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpdateLessonOnGoogleCalendar
{
    public function handle(LessonUpdated $event)
    {

        $lesson = $event->lesson;
        $user = $lesson->user;

        if (!$user->google_token) {
            dd("Manca il google Token");
            return;
        }

        if (!$user->google_refresh_token) {
            dd("Manca il google_refresh_token");
            return;
        }

        if (!$user->google_calendar_id) {
            dd("Manca il calendar_id");
            return;
        }

        // Inizializza Google Service
        $service = new GoogleAccountService($user);

        // Costruisci titolo e descrizione
        $title = ($lesson->student->nome ?? '') . ' ' . ($lesson->student->cognome ?? '');
        $description = $lesson->descrizione();


        if ($lesson->google_event_id) {
            $updated = $service->updateEvent(
                $user->google_calendar_id,
                $lesson->google_event_id,
                $title,
                $lesson->giorno,
                $lesson->ora_inizio,
                $lesson->ora_fine,
                $description
            );

            if ($updated) {
                Log::info("Evento Google aggiornato per lezione {$lesson->id}");
            } else {
                Log::info("Nessuna modifica per lezione {$lesson->id}, skip update Google");
            }

        } else {
            // Se l'evento non esiste, crealo
            $googleEvent = $service->createEvent(
                $user->google_calendar_id,
                $title,
                $lesson->giorno,
                $lesson->ora_inizio,
                $lesson->ora_fine,
                $description
            );

            // Salva l'ID nel DB
            $lesson->update(['google_event_id' => $googleEvent->id]);
            Log::info("Evento Google creato per lezione {$lesson->id}");
        }
    }
}
