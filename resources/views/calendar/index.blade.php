@extends('layouts.app')

@php
    use Carbon\Carbon;
    $firstDay = $today->copy()->startOfMonth(); // Primo giorno del mese
    $lastDay = $today->copy()->endOfMonth(); // Ultimo giorno del mese
    $startWeekDay = $firstDay->dayOfWeekIso; // Giorno della settimana in cui inizia (0=Mon) // 1 (lun) - 7 (dom)
    $daysInMonth = $today->daysInMonth; // Totale giorni nel mese
@endphp


@section('page-title', 'Calendario')

@section('action-buttons')
<div class="flex gap-2">
    {{-- Picker Modalità --}}
    <form action="#" method="GET">
        <div class="inline-flex bg-gray-100 rounded-lg p-1">

            @php
                $modes = [
                    'monthly' => 'Mensile',
                    'weekly' => 'Settimanale',
                    //'daily' => 'Giornaliero'
                ];
                $currentMode = request('mode', 'monthly');
            @endphp

            @foreach ($modes as $value => $label)
                <button
                    type="submit"
                    name="mode"
                    value="{{ $value }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition
                        {{ $currentMode === $value
                            ? 'bg-white text-black shadow'
                            : 'text-gray-600 hover:bg-gray-200'
                        }}">
                    {{ $label }}
                </button>
            @endforeach

        </div>
    </form>

</div>
@endsection



@section('content')
@switch($currentMode)
    @case('weekly')
        @include('calendar.week', ['lessonsByDate' => $lessonsByDate])
        @break
    @case('daily')
        @include('calendar.day', ['date' => $currentDate, 'lessons' => $lessonsByDate[$currentDate] ?? []])
        @break
    @default
        @include('calendar.month', ['lessonsByDate' => $lessonsByDate])
@endswitch
@endsection



