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

        $service = new GoogleAccountService($user);
        $title = $lesson->student->nome . " " . $lesson->student->cognome;
        $description = $lesson->subject->nome;

        if ($lesson->argomento) {
            $description .= " - " . $lesson->argomento;
        }

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

    }
}
