<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $currentMode = $request->query('mode', 'monthly');

        if ($currentMode === 'weekly') {
            // Riferimento settimana: dalla query o oggi
            $refDate = $request->query('startOfWeek', $today->toDateString());
            $startOfWeek = Carbon::parse($refDate)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);

            // Carica lezioni tra inizio e fine settimana, ordinate
            $lessons = Lesson::whereBetween('giorno', [
                    $startOfWeek->toDateString(),
                    $endOfWeek->toDateString(),
                ])
                ->orderBy('giorno')
                ->orderBy('ora_inizio')
                ->get();

            // Raggruppa per giorno
            $lessonsByDate = $lessons->groupBy(function ($lesson) {
                // Se hai cast su giorno → Carbon, altrimenti parse
                return Carbon::parse($lesson->giorno)->toDateString();
            });

            return view('calendar.index', [
                'today' => $today,
                'mode' => 'weekly',
                'startOfWeek' => $startOfWeek,
                'endOfWeek' => $endOfWeek,
                'lessonsByDate' => $lessonsByDate,
            ]);
        } else {
            // Modalità mensile (già come facevi)
            $currentMonth = $request->query('month', $today->month);
            $currentYear = $request->query('year', $today->year);

            $firstDay = Carbon::create($currentYear, $currentMonth, 1);
            $lastDay = $firstDay->copy()->endOfMonth();
            $prevMonth = $firstDay->copy()->subMonth();
            $nextMonth = $firstDay->copy()->addMonth();

            $lessons = Lesson::whereYear('giorno', $currentYear)
                ->whereMonth('giorno', $currentMonth)
                ->orderBy('giorno')
                ->orderBy('ora_inizio')
                ->get();

            $lessonsByDate = $lessons->groupBy(function ($lesson) {
                return Carbon::parse($lesson->giorno)->toDateString();
            });

            return view('calendar.index', [
                'today' => $today,
                'mode' => 'monthly',
                'firstDay' => $firstDay,
                'lastDay' => $lastDay,
                'prevMonth' => $prevMonth,
                'nextMonth' => $nextMonth,
                'currentMonth' => $currentMonth,
                'currentYear' => $currentYear,
                'lessonsByDate' => $lessonsByDate,
            ]);
        }
    }
}
