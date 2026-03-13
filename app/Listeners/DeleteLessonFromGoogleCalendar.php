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

        if (!$user->hasGoogleCalendar() || !$lesson->google_event_id) {
            return;
        }

        try {
            $service = new GoogleAccountService($user);
            if (!$service->isConnected()) {
                return;
            }

            $service->deleteEvent($user->google_calendar_id, $lesson->google_event_id);
            $lesson->update(['google_event_id' => null]);
        } catch (\Exception $e) {
            \Log::warning("Failed to delete Google event: " . $e->getMessage());
        }
    }
}
