@php
use Carbon\Carbon;

// Ottieni la data di riferimento per la settimana (GET param oppure oggi)
$referenceDate = request('startOfWeek', Carbon::today()->toDateString());
$startOfWeek = Carbon::parse($referenceDate)->startOfWeek(); // lunedì
$endOfWeek = $startOfWeek->copy()->endOfWeek(); // domenica

// Array delle date della settimana
$daysOfWeek = [];
for ($d = $startOfWeek->copy(); $d->lte($endOfWeek); $d->addDay()) {
    $daysOfWeek[] = $d->toDateString();
}

// Settimana precedente / successiva
$prevWeek = $startOfWeek->copy()->subWeek();
$nextWeek = $startOfWeek->copy()->addWeek();

$today = Carbon::today();
@endphp

{{-- Navigazione settimane --}}
<div class="flex justify-between items-center mb-4">
    <a href="{{ route('calendar.index', ['mode'=>'weekly', 'startOfWeek'=>$prevWeek->toDateString()]) }}"
       class="secondary-button px-4 py-2">
        &laquo; {{ $prevWeek->format('d M') }} - {{ $prevWeek->copy()->endOfWeek()->format('d M') }}
    </a>

    <h2 class="primary-text text-lg font-semibold">
        {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}
    </h2>

    <a href="{{ route('calendar.index', ['mode'=>'weekly', 'startOfWeek'=>$nextWeek->toDateString()]) }}"
       class="secondary-button px-4 py-2">
        {{ $nextWeek->format('d M') }} - {{ $nextWeek->copy()->endOfWeek()->format('d M') }} &raquo;
    </a>
</div>

{{-- Header giorni della settimana --}}
<div class="grid grid-cols-7 text-center border box-border rounded-t-lg overflow-hidden">
    @foreach (['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'] as $day)
        <div class="py-2 primary-text font-semibold bg-even last:border-r-0">{{ $day }}</div>
    @endforeach
</div>

{{-- Griglia della settimana --}}
<div class="grid grid-cols-7 border box-border border-t-0 rounded-b-lg">
    @foreach ($daysOfWeek as $date)
        @php
            $dayLessons = $lessonsByDate[$date] ?? [];
            // Ordina le lezioni per ora_inizio
            $dayLessons = collect($dayLessons)->sortBy('ora_inizio');
            $isToday = Carbon::parse($date)->isSameDay($today);
            $dayNumber = Carbon::parse($date)->day;
        @endphp

        <div class="border-r border-b box-border relative p-2 flex flex-col min-h-[150px]">
            {{-- Numero del giorno --}}
            <div class="absolute top-4 right-4 text-sm">
                @if ($isToday)
                    <span class="px-2 py-1.5 inline-button rounded-full font-semibold">
                        {{ $dayNumber }}
                    </span>
                @else
                    <span class="secondary-text">{{ $dayNumber }}</span>
                @endif
            </div>

            {{-- Lezioni --}}
            <div class="mt-9 flex flex-col gap-2 overflow-y-auto pb-6">
                @foreach ($dayLessons as $lesson)
                    <a href="{{ route('lessons.show', $lesson->id) }}">
                        <div class="card p-2">
                            {{-- Orario (desktop) --}}
                            <p class="secondary-text text-xs hidden lg:block">
                                {{ $lesson->getOraInizioFormatted() }} - {{ $lesson->getOraFineFormatted() }}
                            </p>

                            {{-- Nome completo (desktop) --}}
                            <p class="primary-text font-medium hidden lg:block">
                                {{ $lesson->student->getNomeCompleto() ?? 'Studente senza nome' }}
                            </p>

                            {{-- Iniziali (mobile) --}}
                            <div class="primary-text lg:hidden flex items-center justify-center h-full text-md font-medium">
                                {{ $lesson->student->getIniziali() ?? 'SN' }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
