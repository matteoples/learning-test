<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\LessonCreated;
use App\Events\LessonUpdated;
use App\Events\LessonDeleted;

use App\Listeners\CreateLessonOnGoogleCalendar;
use App\Listeners\UpdateLessonOnGoogleCalendar;
use App\Listeners\DeleteLessonFromGoogleCalendar;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        LessonCreated::class => [
            CreateLessonOnGoogleCalendar::class,
        ],
        LessonUpdated::class => [
            UpdateLessonOnGoogleCalendar::class,
        ],
        LessonDeleted::class => [
            DeleteLessonFromGoogleCalendar::class,
        ],
    ];
}
