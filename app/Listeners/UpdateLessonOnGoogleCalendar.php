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

        if (!$user->hasGoogleCalendar()) {
            return;
        }

        try {
            $service = new GoogleAccountService($user);
            if (!$service->isConnected()) {
                return;
            }

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
                    \Log::info("Evento Google aggiornato per lezione {$lesson->id}");
                }
            } else {
                $googleEvent = $service->createEvent(
                    $user->google_calendar_id,
                    $title,
                    $lesson->giorno,
                    $lesson->ora_inizio,
                    $lesson->ora_fine,
                    $description
                );

                $lesson->update(['google_event_id' => $googleEvent->id]);
                \Log::info("Evento Google creato per lezione {$lesson->id}");
            }
        } catch (\Exception $e) {
            \Log::warning("Failed to update Google event: " . $e->getMessage());
        }
    }
}
