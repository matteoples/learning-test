<?php

namespace App\Services;

use App\Models\User;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Google\Client as GoogleClient;
use Google\Service\Calendar as GoogleCalendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;


class GoogleAccountService
{
    protected GoogleClient $client;
    protected GoogleCalendar $calendarService;
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->client = new GoogleClient();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->setAccessType('offline');
        $this->client->setScopes([
            GoogleCalendar::CALENDAR
        ]);

        $this->setAccessToken();

        $this->calendarService = new GoogleCalendar($this->client);
    }

    protected function setAccessToken(): void
    {
        if (!$this->user->google_token) {
            //dd($this->user);
            throw new \Exception('Google access token missing.');
        }

        $this->client->setAccessToken([
            'access_token' => $this->user->google_token,
            'refresh_token' => $this->user->google_refresh_token,
        ]);

        // Refresh automatico se scaduto
        if ($this->client->isAccessTokenExpired()) {

            if (!$this->user->google_refresh_token) {
                throw new \Exception('Google refresh token missing.');
            }

            $newToken = $this->client->fetchAccessTokenWithRefreshToken(
                $this->user->google_refresh_token
            );

            if (isset($newToken['error'])) {
                throw new \Exception('Unable to refresh Google token.');
            }

            $this->user->google_token = $newToken['access_token'];
            $this->user->save();

            $this->client->setAccessToken([
                'access_token' => $newToken['access_token'],
                'refresh_token' => $this->user->google_refresh_token,
            ]);
        }
    }

    public function createCalendar(string $name): string
    {
        $calendar = new \Google\Service\Calendar\Calendar([
            'summary' => $name,
            'timeZone' => config('app.timezone'),
        ]);

        $createdCalendar = $this->calendarService->calendars->insert($calendar);

        $this->createEvent(
            $createdCalendar->id,
            'Evento di prova',
            now()->format('Y-m-d'),
            now()->format('H:i:s'),
            now()->addHour()->format('H:i:s'),
            'Descrizione evento'
        );

        return $createdCalendar->id;
    }

    public function createEvent(
        string $calendarId,
        string $summary,
        ?string $giorno = null,
        ?string $oraInizio = null,
        ?string $oraFine = null,
        ?string $description = null,
    ) {
        // Costruisci start/end con Carbon usando la timezone corretta
        try {
            if ($giorno && $oraInizio && $oraFine) {
                $start = Carbon::parse("{$giorno} {$oraInizio}", config('app.timezone'));
                $end   = Carbon::parse("{$giorno} {$oraFine}", config('app.timezone'));
            } else {
                // fallback se manca data/ora
                $start = Carbon::parse('2026-01-01 00:00:00', config('app.timezone'));
                $end   = (clone $start)->addMinutes(5);
            }
        } catch (\Exception $e) {
            // fallback in caso di parsing fallito
            $start = Carbon::parse('2026-01-01 00:00:00', config('app.timezone'));
            $end   = (clone $start)->addMinutes(5);
        }

        $event = new Event();
        $event->setSummary($summary);
        $event->setDescription($description);

        // Crea oggetti EventDateTime per start e end
        $startEvent = new EventDateTime();
        $startEvent->setDateTime($start->toIso8601String());
        $startEvent->setTimeZone(config('app.timezone'));
        $event->setStart($startEvent);

        $endEvent = new EventDateTime();
        $endEvent->setDateTime($end->toIso8601String());
        $endEvent->setTimeZone(config('app.timezone'));
        $event->setEnd($endEvent);

        // Inserisci l'evento su Google Calendar
        return $this->calendarService->events->insert($calendarId, $event);
    }


    public function updateEvent(
        string $calendarId,
        string $eventId,
        string $summary,
        ?string $giorno = null,
        ?string $oraInizio = null,
        ?string $oraFine = null,
        ?string $description = null
    ) {
        // Recupera l'evento esistente
        $event = $this->calendarService->events->get($calendarId, $eventId);

        // Combina giorno e ora in Carbon per i nuovi valori
        try {
            if ($giorno && $oraInizio && $oraFine) {
                $newStart = Carbon::parse($giorno . ' ' . $oraInizio, config('app.timezone'));
                $newEnd   = Carbon::parse($giorno . ' ' . $oraFine, config('app.timezone'));
            } else {
                $newStart = Carbon::parse('2026-01-01 00:00:00', config('app.timezone'));
                $newEnd   = (clone $newStart)->addMinutes(5);
            }
        } catch (\Exception $e) {
            $newStart = Carbon::parse('2026-01-01 00:00:00', config('app.timezone'));
            $newEnd   = (clone $newStart)->addMinutes(5);
        }

        $updateNeeded = false;

        // Controlla se il summary o description sono diversi
        if ($event->getSummary() !== $summary) {
            $event->setSummary($summary);
            $updateNeeded = true;
        }

        if ($event->getDescription() !== $description) {
            $event->setDescription($description);
            $updateNeeded = true;
        }

        // Controlla se start/end sono diversi
        $currentStart = Carbon::parse($event->start->dateTime)->toIso8601String();
        $currentEnd   = Carbon::parse($event->end->dateTime)->toIso8601String();

        if ($currentStart !== $newStart->toIso8601String()) {
            $event->setStart(
                new EventDateTime([
                    'dateTime' => $newStart->toIso8601String(),
                    'timeZone' => config('app.timezone'),
                ])
            );
            $updateNeeded = true;
        }

        if ($currentEnd !== $newEnd->toIso8601String()) {
            $event->setEnd(
                new EventDateTime([
                    'dateTime' => $newEnd->toIso8601String(),
                    'timeZone' => config('app.timezone'),
                ])
            );
            $updateNeeded = true;
        }

        // Se non ci sono modifiche, non fare update
        if (!$updateNeeded) {
            return null; // oppure false per indicare "nessuna modifica"
        }

        // Salva le modifiche su Google Calendar
        return $this->calendarService->events->update($calendarId, $eventId, $event);
    }

    
    public function deleteEvent(string $calendarId, string $eventId)
    {
        return $this->calendarService->events->delete($calendarId, $eventId);
    }


    public function sincronizzaCalendario(): int
    {
        $lessons = Lesson::with(['student','subject'])
            ->where('user_id', $this->user->id)
            ->whereNull('google_event_id')
            ->orderByDesc('giorno')
            ->orderByDesc('ora_inizio')
            ->limit(40)
            ->get();

        $count = 0;

        DB::beginTransaction();

        try {

            foreach ($lessons as $lesson) {

                $title = trim(
                    ($lesson->student->nome ?? '') . ' ' .
                    ($lesson->student->cognome ?? '')
                );

                $description = $lesson->subject->nome ?? '';
                if ($lesson->argomento) {
                    $description .= ' - ' . $lesson->argomento;
                }

                $googleEvent = $this->createEvent(
                    $this->user->google_calendar_id,
                    $title,
                    $lesson->giorno,
                    $lesson->ora_inizio,
                    $lesson->ora_fine,
                    $description
                );

                $lesson->update([
                    'google_event_id' => $googleEvent->id
                ]);

                $count++;
            }

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollBack();
            throw $e;
        }

        return $count;
    }


    public function resetCalendario(): int
    {
        // Prendi tutte le lezioni dell'utente che hanno un google_event_id
        $lessons = Lesson::where('user_id', $this->user->id)
            ->whereNotNull('google_event_id')
            ->get();

        $count = 0;

        foreach ($lessons as $lesson) {
            try {
                // Elimina l'evento dal Google Calendar
                $this->deleteEvent($this->user->google_calendar_id, $lesson->google_event_id);

                // Azzeriamo l'ID dell'evento nel DB
                $lesson->update(['google_event_id' => null]);

                $count++;
            } catch (\Throwable $e) {
                // Log in caso di errore ma continuiamo con le altre lezioni
                \Log::error("Errore cancellando evento Google ID {$lesson->google_event_id}: " . $e->getMessage());
            }
        }

        return $count; // ritorna il numero di eventi cancellati
    }

}
