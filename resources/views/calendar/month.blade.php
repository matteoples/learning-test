@php
    use Carbon\Carbon;
    use App\Enums\FontWeight as FW;

    // Date Carbon per mese precedente e successivo
    $prevMonthDate = Carbon::create($currentYear, $currentMonth, 1)->subMonth();
    $nextMonthDate = Carbon::create($currentYear, $currentMonth, 1)->addMonth();

    // Nome del mese corrente in italiano
    $monthName = Carbon::create($currentYear, $currentMonth, 1)
        ->locale('it')
        ->monthName;

    $daysInMonth = $firstDay->daysInMonth;
    $startWeekDay = $firstDay->dayOfWeekIso; // 1 = lunedì

    $days = ['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'];
@endphp

{{-- NAVIGAZIONE MESE --}}
<div class="flex justify-between items-center mb-4">
    <a href="{{ route('calendar.index', ['month' => $prevMonthDate->month, 'year' => $prevMonthDate->year]) }}">
        <x-button variant="secondary" icon="prev-chevron"> {{ $prevMonthDate->translatedFormat('M Y') }}  </x-button>
    </a>

    <x-title> {{ ucfirst($monthName) }} {{ $currentYear }} </x-title>

    <a href="{{ route('calendar.index', ['month' => $nextMonthDate->month, 'year' => $nextMonthDate->year]) }}">
        <x-button variant="secondary" icon="next-chevron"> {{ $nextMonthDate->translatedFormat('M Y') }}  </x-button>
    </a>
</div>

{{-- HEADER GIORNI SETTIMANA --}}
<div class="grid grid-cols-7 text-center border box-border rounded-t-lg overflow-hidden">
    @foreach ($days as $day)
        <x-text :weight="FW::Semibold" class="py-2">{{ $day }}</x-text>
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
            <div class="mb-2">
                <div class="absolute top-4 right-4 text-sm">
                    @if ($isToday)
                        <span class="px-2 py-1.5 inline-color rounded-full font-semibold">
                            {{ $day }}
                        </span>
                    @else
                        <x-label> {{ $day }} </x-label>
                    @endif
                </div>
            </div>
            

            {{-- Lezioni del giorno --}}
            <div class="mt-9 flex flex-col gap-2 overflow-y-auto pb-6">
                @foreach ($dayLessons as $lesson)
                
                    <a href="{{ route('lessons.show', $lesson->id) }}">
                        <x-box-container size="small">
                            <x-label class="hidden xl:block">
                                {{ $lesson->getOraInizioFormatted() }} - {{ $lesson->getOraFineFormatted() }}
                            </x-label>

                            <x-text :weight="FW::Semibold" class="hidden xl:block">
                                {{ $lesson->student->getNomeCognome() ?? 'Studente senza nome' }}
                            </x-text>
                    
                            {{-- Iniziali (mobile) --}}
                            <x-text :weight="FW::Semibold" class="xl:hidden w-full">
                                {{ $lesson->student->getIniziali() ?? 'SN' }}
                            </x-text>
                        </x-box-container>
                    </a>

                @endforeach
            </div>
        </div>
    @endfor
</div>
