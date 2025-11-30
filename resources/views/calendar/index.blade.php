@extends('layouts.app')

@php
    $currentMode = request('mode', 'monthly');
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
@endphp


@section('page-title', 'Calendario')



@section('action-buttons')
<div class="flex gap-2">
    {{-- Picker Modalità --}}
    <form action="#" method="GET">
        <div class="inline-flex bg-odd rounded-lg p-1">
            @php
                $modes = [
                    'monthly' => 'Mensile',
                    'weekly' => 'Settimanale',
                    //'daily' => 'Giornaliero'
                ];
            @endphp

            @foreach ($modes as $value => $label)
                <button
                    type="submit"
                    name="mode"
                    value="{{ $value }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition
                        {{ $currentMode === $value
                            ? 'bg-even primary-text shadow cursor-default'
                            : 'primary-text hover:bg-odd cursor-pointer'
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
        @include('calendar.day', [
            'date' => $today->toDateString(),
            'lessons' => $lessonsByDate[$today->toDateString()] ?? []
        ])
        @break

    @default
        @include('calendar.month', [
            'firstDay' => $firstDay,
            'lessonsByDate' => $lessonsByDate,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear
        ])
@endswitch
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tailwind 'sm' breakpoint = 640px
        if (window.innerWidth < 640) {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('mode') !== 'weekly') {
                urlParams.set('mode', 'weekly');
                window.location.search = urlParams.toString();
            }
        }
    });
</script>