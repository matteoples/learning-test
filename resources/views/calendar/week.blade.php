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
       class="secondary-button px-3 py-2 sm:px-2 sm:py-2">    
        <div class="flex gap-1 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
            <path fill-rule="evenodd" d="M4.72 9.47a.75.75 0 0 0 0 1.06l4.25 4.25a.75.75 0 1 0 1.06-1.06L6.31 10l3.72-3.72a.75.75 0 1 0-1.06-1.06L4.72 9.47Zm9.25-4.25L9.72 9.47a.75.75 0 0 0 0 1.06l4.25 4.25a.75.75 0 1 0 1.06-1.06L11.31 10l3.72-3.72a.75.75 0 0 0-1.06-1.06Z" clip-rule="evenodd" />
            </svg>
            <span class="hidden sm:inline">{{ $prevWeek->format('d M') }} - {{ $prevWeek->copy()->endOfWeek()->format('d M') }}</span>
       </div>
    
    </a>

    <h2 class="primary-text text-lg font-semibold">
        {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}
    </h2>

    <a href="{{ route('calendar.index', ['mode'=>'weekly', 'startOfWeek'=>$nextWeek->toDateString()]) }}"
       class="secondary-button px-3 py-2 sm:px-2 sm:py-2">

       <div class="flex gap-1 items-center">
            <span class="hidden sm:inline">{{ $nextWeek->format('d M') }} - {{ $nextWeek->copy()->endOfWeek()->format('d M') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
            <path fill-rule="evenodd" d="M15.28 9.47a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 1 1-1.06-1.06L13.69 10 9.97 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25ZM6.03 5.22l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L8.69 10 4.97 6.28a.75.75 0 0 1 1.06-1.06Z" clip-rule="evenodd" />
            </svg>
       </div>
    </a>
</div>

{{-- Header giorni della settimana --}}


{{-- Griglia della settimana --}}
<div class="grid grid-cols-1 border box-border rounded-lg mb-10">
    @foreach ($daysOfWeek as $date)
        @php
            $dayLessons = $lessonsByDate[$date] ?? [];
            // Ordina le lezioni per ora_inizio
            $dayLessons = collect($dayLessons)->sortBy('ora_inizio');
            $isToday = Carbon::parse($date)->isSameDay($today);
             $dayName = Carbon::parse($date)->isoFormat('ddd'); // Lun, Mar, ...
            $dayNumber = Carbon::parse($date)->day;
        @endphp

        <div class="border-b box-border relative p-2 flex flex-col">
            {{-- Numero del giorno --}}
            <div class="p-2">
                @if ($isToday)
                    <span class="px-2 py-1.5 inline-button rounded-full font-semibold">
                        {{ $dayName }} {{ $dayNumber }}
                    </span>
                @else
                    <span class="primary-text font-semibold">{{ $dayName }} {{ $dayNumber }}</span>
                @endif
            </div>
            <p> </p>

            {{-- Lezioni --}}
            <div class="mt-9 flex flex-col gap-2 overflow-y-auto pb-6">
                @foreach ($dayLessons as $lesson)
                    <a href="{{ route('lessons.show', $lesson->id) }}">
                        <div class="card p-2">
                            {{-- Orario (desktop) --}}
                            <p class="secondary-text text-xs">
                                {{ $lesson->getOraInizioFormatted() }} - {{ $lesson->getOraFineFormatted() }}
                            </p>

                            {{-- Nome completo (desktop) --}}
                            <p class="primary-text font-medium">
                                {{ $lesson->student->getNomeCompleto() ?? 'Studente senza nome' }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>