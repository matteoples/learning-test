@php
    use Carbon\Carbon;

    // Ottieni mese e anno dai parametri GET, altrimenti usa oggi
    $currentMonth = request('month', $today->month);
    $currentYear = request('year', $today->year);

    $firstDay = Carbon::create($currentYear, $currentMonth, 1);
    $lastDay = $firstDay->copy()->endOfMonth();
    $startWeekDay = $firstDay->dayOfWeekIso;
    $daysInMonth = $firstDay->daysInMonth;

    $prevMonth = $firstDay->copy()->subMonth();
    $nextMonth = $firstDay->copy()->addMonth();
@endphp

{{-- Navigazione mesi --}}
<div class="flex justify-between items-center mb-4">
    <a href="{{ route('calendar.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        &laquo; {{ $prevMonth->format('M Y') }}
    </a>

    <h2 class="text-lg font-semibold">{{ $firstDay->format('F Y') }}</h2>

    <a href="{{ route('calendar.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        {{ $nextMonth->format('M Y') }} &raquo;
    </a>
</div>

{{-- HEADER con i giorni della settimana --}}
<div class="grid grid-cols-7 text-center border border-gray-300 rounded-t-lg overflow-hidden">
    @foreach (['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'] as $day)
        <div class="py-2 font-semibold bg-gray-50 last:border-r-0">
            {{ $day }}
        </div>
    @endforeach
</div>

{{-- GRIGLIA DEL MESE --}}
<div class="grid grid-cols-7 border border-gray-300 border-t-0 rounded-b-lg">
    {{-- Celle vuote prima del primo giorno --}}
    @for ($i = 1; $i < $startWeekDay; $i++)
        <div class="flex flex-col min-h-[75px] border-r border-b border-gray-300 bg-gray-50"></div>
    @endfor

    {{-- Giorni del mese --}}
    @for ($day = 1; $day <= $daysInMonth; $day++)
        @php
            $date = Carbon::create($currentYear, $currentMonth, $day)->toDateString();
            $isToday = Carbon::create($currentYear, $currentMonth, $day)->isSameDay($today);

            $dayLessons = $lessonsByDate[$date] ?? [];
        @endphp

        <div class="border-r border-b border-gray-300 relative p-2 flex flex-col min-h-[75px]">
            {{-- Numero del giorno --}}
            <div class="absolute top-3 right-2 text-sm">
                @if ($isToday)
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold">
                        {{ $day }}
                    </span>
                @else
                    <span class="text-gray-600">{{ $day }}</span>
                @endif
            </div>

            {{-- Lezioni --}}
            <div class="mt-9 flex flex-col gap-2 overflow-y-auto pb-10">
                @foreach ($dayLessons as $lesson)
                    <a href="{{ route('lessons.show', $lesson->id) }}">

                        <div class="bg-[#FDFDFC] dark:bg-[#161615] p-2 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200 flex flex-col h-full">
                            {{-- Orario lezione (solo su lg) --}}
                            <p class="text-gray-500 text-xs hidden justify-center lg:justify-start lg:block">
                                {{ $lesson->getOraInizioFormatted() }} - {{ $lesson->getOraFineFormatted() }}
                            </p>

                            {{-- Nome completo su lg --}}
                            <p class="font-medium hidden lg:block">
                                {{ $lesson->student->getNomeCompleto() ?? 'Studente senza nome' }}
                            </p>

                            {{-- Iniziali centrate su md o più piccoli --}}
                            <div class="lg:hidden flex items-center justify-center h-full text-md font-medium">
                                {{ $lesson->student->getIniziali() ?? 'SN' }}
                            </div>
                        </div>
                    </a>
                @endforeach
                </div>
        </div>
    @endfor
</div>