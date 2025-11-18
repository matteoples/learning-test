@php
use Carbon\Carbon;

// Ottieni la data di riferimento per la settimana (parametro GET), altrimenti oggi
$referenceDate = request('startOfWeek', Carbon::today()->toDateString());
$startOfWeek = Carbon::parse($referenceDate)->startOfWeek(); // lunedì
$endOfWeek = $startOfWeek->copy()->endOfWeek(); // domenica

// Prepara array dei giorni della settimana
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
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        &laquo; {{ $prevWeek->format('d M') }} - {{ $prevWeek->copy()->endOfWeek()->format('d M') }}
    </a>

    <h2 class="text-lg font-semibold">
        {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}
    </h2>

    <a href="{{ route('calendar.index', ['mode'=>'weekly', 'startOfWeek'=>$nextWeek->toDateString()]) }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        {{ $nextWeek->format('d M') }} - {{ $nextWeek->copy()->endOfWeek()->format('d M') }} &raquo;
    </a>
</div>


{{-- Header giorni --}}
<div class="grid grid-cols-7 text-center border border-gray-300 rounded-t-lg overflow-hidden">
    @foreach (['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'] as $day)
        <div class="py-2 font-semibold bg-gray-50">{{ $day }}</div>
    @endforeach
</div>

{{-- Griglia settimana --}}
<div class="grid grid-cols-7 border border-gray-300 border-t-0 rounded-b-lg">
    @foreach ($daysOfWeek as $date)
        @php
            $dayLessons = $lessonsByDate[$date] ?? [];
            $isToday = Carbon::parse($date)->isSameDay($today);
            $dayNum = Carbon::parse($date)->day;
        @endphp

        <div class="border-r border-b border-gray-300 relative p-2 flex flex-col min-h-[150px]">
            {{-- Numero del giorno --}}
            <div class="absolute top-3 right-2 text-sm">
                @if($isToday)
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full">{{ $dayNum }}</span>
                @else
                    <span class="text-gray-600">{{ $dayNum }}</span>
                @endif
            </div>

            {{-- Lezioni --}}
            <div class="mt-9 flex flex-col gap-2 overflow-y-auto pb-10">
                @foreach ($dayLessons as $lesson)
                    <a href="{{ route('lessons.show', $lesson->id) }}">
                        <div class="bg-[#FDFDFC] dark:bg-[#161615] p-2 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200 flex flex-col h-full">
                            <p class="text-gray-500 text-xs">{{ $lesson->getOraInizioFormatted() }} - {{$lesson->getOraFineFormatted()}}</p>
                            <p class="font-medium">{{ $lesson->student->getNomeCompleto() ?? 'Studente senza nome' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
