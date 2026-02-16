@extends('layouts.app')

@php
    $studentName = $lesson->student->getNomeCompleto();
    $luoghi = ['Online', 'Casa Tutor', 'Casa Cliente', 'Biblioteca', 'Altro'];
@endphp

@section('page-title')
Modifica Lezione
<span class="hidden md:inline"> di {{ $studentName }}</span>
@endsection
@section('back-button-route', route('students.show', $lesson->student))

@section('action-buttons')
<div class="flex gap-2">
    <button type="submit" form="edit-lesson-form" class="primary-button px-4 py-2">
        Salva
    </button>
</div>
@endsection

@section('content')

<form id="edit-lesson-form" action="{{ route('lessons.update', $lesson) }}" method="POST" class="flex flex-col gap-6">
    @csrf
    @method('PUT')

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Giorno --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Giorno</label>
            <input type="date" name="giorno"
                   value="{{ \Carbon\Carbon::parse($lesson->giorno)->format('Y-m-d') }}"
                   class="input-field" />
        </div>

        <div class="flex flex-row gap-4">
            {{-- Ora inizio --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">Ora inizio</label>
                <input type="time" name="ora_inizio"
                       value="{{ \Carbon\Carbon::parse($lesson->ora_inizio)->format('H:i') }}"
                       class="input-field w-full" />
            </div>

            {{-- Ora fine --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">Ora fine</label>
                <input type="time" name="ora_fine"
                       value="{{ \Carbon\Carbon::parse($lesson->ora_fine)->format('H:i') }}"
                       class="input-field w-full" />
            </div>
        </div>
    </div>

    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Luogo --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Luogo</label>
            
            <select name="luogo" class="input-field">
                <option value="">---</option>
                @foreach($luoghi as $luogo)
                    <option value="{{ $luogo }}" @selected(old('luogo', $lesson->luogo) === $luogo)>
                        {{ $luogo }}
                    </option>
                @endforeach
            </select>

        </div>



        {{-- Materia --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Materia</label>
            <select name="subject_id" class="input-field">
                <option value="">---</option>

                @foreach($userSubjects as $subject)
                    <option value="{{ $subject->id }}" @selected($lesson->subject_id === $subject->id)>
                        {{ $subject->nome }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Terza riga -->
    <div class="flex flex-col gap-1">
        <label class="primary-text text-sm font-medium">Argomento</label>
        <textarea name="argomento" rows="4" class="input-field w-full">{{ $lesson->argomento ?? '' }}</textarea>
    </div>

</form>

<div class="mt-6">
    <div class="border-t box-border mb-6"></div>

    <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questa lezione?');">
        @csrf
        @method('DELETE')
        <div class="flex justify-end">
            <button type="submit" class="destructive-button px-4 py-2">
                Elimina Lezione
            </button>
        </div>
    </form>
</div>

@endsection
