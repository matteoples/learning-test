<?php

namespace App\Listeners;

use App\Events\LessonCreated;
use App\Services\GoogleAccountService;
use Illuminate\Support\Facades\Log;

class CreateLessonOnGoogleCalendar
{

    public function handle(LessonCreated $event): void
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

            $title = $lesson->student->nome . " " . $lesson->student->cognome;
            $description = $lesson->descrizione();

            $googleEvent = $service->createEvent(
                $user->google_calendar_id,
                $title,
                $lesson->giorno,
                $lesson->ora_inizio,
                $lesson->ora_fine,
                $description
            );

            $lesson->update([
                'google_event_id' => $googleEvent->id
            ]);
        } catch (\Exception $e) {
            \Log::warning("Failed to create Google event: " . $e->getMessage());
        }

    }
}
