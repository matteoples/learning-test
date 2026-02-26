@extends('layouts.app')

@php
    $studentName = $lesson->student->getNomeCognome();
@endphp

@section('page-title')
Dettagli Lezione
<span class="hidden md:inline"> di {{ $studentName }}</span>
@endsection
@section('back-button-route', route('students.show', $lesson->student))

@section('action-buttons')
<div class="flex gap-2">
    <a href="{{ route('lessons.edit', $lesson) }}" class="primary-button px-4 py-2">
        Modifica
    </a>
</div>
@endsection

@section('content')


<div class="flex flex-col md:flex-row gap-8">
    <div class="w-full md:w-[500px] flex flex-col gap-4">
        {{-- Giorno --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Giorno</label>
            <input type="date" value="{{ $lesson->getGiornoFormatted() }}" readonly class="input-field" />
        </div>

        {{-- Orario --}}
        <div class="flex flex-row gap-4">
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">Ora inizio</label>
                <input type="time" value="{{ $lesson->getOraInizioFormatted() }}" readonly class="input-field w-full" />
            </div>

            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">Ora fine</label>
                <input type="time" value="{{ $lesson->getOraFineFormatted() }}" readonly class="input-field w-full" />
            </div>
        </div>

        {{-- Luogo --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Luogo</label>
            <input type="text" value="{{ $lesson->luogo ?? 'N/A' }}" readonly class="input-field" />
        </div>

        {{-- Materia --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Materia</label>
            <input type="text" value="{{ $lesson->subject->nome ?? 'N/A' }}"  readonly class="input-field"/>
        </div>
    </div>

     <div class="w-full flex flex-col gap-1">
        <label class="primary-text text-sm font-medium">Argomento</label>
        <textarea rows="11" readonly class="input-field w-full">{{ $lesson->argomento ?? '' }}</textarea>
    </div>

</div>


@endsection
