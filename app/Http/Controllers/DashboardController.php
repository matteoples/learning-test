<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    /**
     * PROSSIMI 5 APPUNTAMENTI (lezioni future)
     */
    $nextLessons = $user->lessons()
    ->with('student')
    ->where(function ($query) {
        $query->where('giorno', '>', today())
              ->orWhere(function ($q) {
                  $q->where('giorno', today())
                    ->where('ora_fine', '>=', now()->format('H:i:s'));
              });
    })
    ->orderBy('giorno')
    ->orderBy('ora_inizio')
    ->limit(5)
    ->get();

    /**
     * STUDENTI CON DEBITI E CREDITI
     */
    $students = $user->students()->get();

    $debts = $students
        ->filter(fn ($student) => $student->saldo() < 0)
        ->sortBy(fn ($student) => $student->saldo())
        ->values();

    $credits = $students
        ->filter(fn ($student) => $student->saldo() > 0)
        ->sortByDesc(fn ($student) => $student->saldo())
        ->values();

    return view('dashboard', compact(
        'nextLessons',
        'debts',
        'credits'
    ));
}
}
