@php
    use Carbon\Carbon;

    // Date Carbon per mese precedente e successivo
    $prevMonthDate = Carbon::create($currentYear, $currentMonth, 1)->subMonth();
    $nextMonthDate = Carbon::create($currentYear, $currentMonth, 1)->addMonth();

    // Nome del mese corrente in italiano
    $monthName = Carbon::create($currentYear, $currentMonth, 1)
        ->locale('it')
        ->monthName;

    $daysInMonth = $firstDay->daysInMonth;
    $startWeekDay = $firstDay->dayOfWeekIso; // 1 = lunedì
@endphp

{{-- NAVIGAZIONE MESE --}}
<div class="flex justify-between items-center mb-4">
    <a href="{{ route('calendar.index', ['month' => $prevMonthDate->month, 'year' => $prevMonthDate->year]) }}"
       class="secondary-button px-4 py-2">
        &laquo; {{ $prevMonthDate->translatedFormat('M Y') }}
    </a>

    <h2 class="primary-text text-lg font-semibold">
        {{ ucfirst($monthName) }} {{ $currentYear }}
    </h2>

    <a href="{{ route('calendar.index', ['month' => $nextMonthDate->month, 'year' => $nextMonthDate->year]) }}"
       class="secondary-button px-4 py-2">
        {{ $nextMonthDate->translatedFormat('M Y') }} &raquo;
    </a>
</div>

{{-- HEADER GIORNI SETTIMANA --}}
<div class="grid grid-cols-7 text-center border box-border rounded-t-lg overflow-hidden">
    @foreach (['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'] as $day)
        <div class="py-2 primary-text font-semibold bg-even last:border-r-0">
            {{ $day }}
        </div>
    @endforeach
</div>

{{-- GRIGLIA DEL MESE --}}
<div class="grid grid-cols-7 border box-border border-t-0 rounded-b-lg">
    {{-- Celle vuote prima del primo giorno del mese --}}
    @for ($i = 1; $i < $startWeekDay; $i++)
        <div class="flex flex-col min-h-[75px] border-r border-b box-border bg-odd"></div>
    @endfor

    {{-- Giorni del mese --}}
    @for ($day = 1; $day <= $daysInMonth; $day++)
        @php
            $date = Carbon::create($currentYear, $currentMonth, $day)->toDateString();
            $isToday = Carbon::create($currentYear, $currentMonth, $day)->isSameDay($today);
            $dayLessons = $lessonsByDate[$date] ?? [];
        @endphp

        <div class="border-r border-b box-border relative p-2 px-4 flex flex-col min-h-[70px]">
            {{-- Numero del giorno --}}
            <div class="absolute top-4 right-4 text-sm">
                @if ($isToday)
                    <span class="px-2 py-1.5 inline-button rounded-full font-semibold">
                        {{ $day }}
                    </span>
                @else
                    <span class="secondary-text">{{ $day }}</span>
                @endif
            </div>

            {{-- Lezioni del giorno --}}
            <div class="mt-9 flex flex-col gap-2 overflow-y-auto pb-6">
                @foreach ($dayLessons as $lesson)
                    <a href="{{ route('lessons.show', $lesson->id) }}">
                        <div class="card p-2">
                            {{-- Orario (solo desktop) --}}
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
    @endfor
</div>
