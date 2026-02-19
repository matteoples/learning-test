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

        // Controlla che l'utente abbia token e calendar_id
        if (!$user->google_access_token || !$user->google_refresh_token || !$user->google_calendar_id) {
            Log::warning("Utente {$user->id} mancano token o calendar_id, skip Google update");
            return;
        }

        // Inizializza Google Service
        $service = new GoogleAccountService($user);

        // Costruisci titolo e descrizione
        $title = ($lesson->student->nome ?? '') . ' ' . ($lesson->student->cognome ?? '');
        $description = $lesson->subject->nome ?? '';
        if ($lesson->argomento) {
            $description .= ' - ' . $lesson->argomento;
        }

        // Se l'evento esiste già
        if ($lesson->google_event_id) {

            // Recupera l'evento dal servizio Google
            $eventGoogle = $service->getEvent($user->google_calendar_id, $lesson->google_event_id);

            // Estrai i valori correnti
            $currentTitle = $eventGoogle->getSummary();
            $currentDescription = $eventGoogle->getDescription();
            $currentStart = Carbon::parse($eventGoogle->start->dateTime)->toIso8601String();
            $currentEnd = Carbon::parse($eventGoogle->end->dateTime)->toIso8601String();

            // Calcola i nuovi valori
            $newStart = Carbon::parse($lesson->giorno . ' ' . $lesson->ora_inizio)->toIso8601String();
            $newEnd   = Carbon::parse($lesson->giorno . ' ' . $lesson->ora_fine)->toIso8601String();

            // Confronta i campi
            if ($title !== $currentTitle ||
                $description !== $currentDescription ||
                $newStart !== $currentStart ||
                $newEnd !== $currentEnd
            ) {
                $service->updateEvent(
                    $user->google_calendar_id,
                    $lesson->google_event_id,
                    $title,
                    $lesson->giorno,
                    $lesson->ora_inizio,
                    $lesson->ora_fine,
                    $description
                );
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
