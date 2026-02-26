@php
use Carbon\Carbon;
use App\Enums\FontWeight as FW;

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

{{-- NAVIGAZIONE MESE --}}
<div class="flex justify-between items-center mb-4">
    <a href="{{ route('calendar.index', ['mode'=>'weekly', 'startOfWeek'=>$prevWeek->toDateString()]) }}">
        <x-button variant="secondary" icon="prev-chevron">
            <x-text class="hidden sm:inline">
                {{ $prevWeek->format('d M') }} - {{ $prevWeek->copy()->endOfWeek()->format('d M') }}
            </x-text>
        </x-button>
    </a>

    <x-title> {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }} </x-title>

    <a href="{{ route('calendar.index', ['mode'=>'weekly', 'startOfWeek'=>$nextWeek->toDateString()]) }}">
        <x-button variant="secondary" icon="next-chevron">
            <x-text class="hidden sm:inline">{{ $nextWeek->format('d M') }} - {{ $nextWeek->copy()->endOfWeek()->format('d M') }}</x-text>
        </x-button>
    </a>
</div>



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
                    <span class="px-2 py-1.5 inline-color rounded-full font-semibold">
                        {{ $dayName }} {{ $dayNumber }}
                    </span>
                @else
                    <span class="primary-text font-semibold">{{ $dayName }} {{ $dayNumber }}</span>
                @endif
            </div>
            <p> </p>

            {{-- Lezioni --}}
            <div class="mt-5 flex flex-col gap-2 overflow-y-auto pb-6">
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
    @endforeach
</div>