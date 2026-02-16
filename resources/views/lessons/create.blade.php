@extends('layouts.app')

@php
    $studentName = $student->getNomeCompleto();
    $luoghi = ['Online', 'Casa Tutor', 'Casa Cliente', 'Biblioteca', 'Altro'];
@endphp

@section('page-title')
Nuova Lezione
<span class="hidden md:inline"> per {{ $studentName }}</span>
@endsection
@section('back-button-route', route('students.show', $student))

@section('action-buttons')
<div class="flex gap-2">
    {{-- Bottone Salva --}}
    <button type="submit" form="create-lesson-form" class="primary-button px-4 py-2">
        Salva
    </button>
</div>
@endsection

@section('content')

<form id="create-lesson-form" action="{{ route('lessons.store', $student) }}" method="POST" class="flex flex-col gap-6">
    @csrf

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Giorno --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">
                Giorno <span class="text-red-500">*</span>
            </label>
            <input type="date" name="giorno" required value="{{ now()->format('Y-m-d') }}" class="input-field">
        </div>

        <div class="flex flex-row gap-4">
            {{-- Ora inizio --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">
                    Ora inizio <span class="text-red-500">*</span>
                </label>
                <input type="time" name="ora_inizio" required value="10:00" class="input-field w-full">
            </div>

            {{-- Ora fine --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">
                    Ora fine <span class="text-red-500">*</span>
                </label>
                <input type="time" name="ora_fine" required value="11:00" class="input-field w-full">
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

                @php
                    $luoghi = ['Online', 'Casa Tutor', 'Casa Cliente', 'Biblioteca', 'Altro'];
                @endphp

                @foreach($luoghi as $luogo)
                    <option value="{{ $luogo }}" {{ old('luogo') === $luogo ? 'selected' : '' }}>
                        {{ $luogo }}
                    </option>
                @endforeach
            </select>

        </div>

        {{-- Materia --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Materia</label>
            <select name="subject_id" class="input-field" required>
                <option value="">---</option>

                @foreach($userSubjects as $subject)
                    <option value="{{ $subject->id }}">
                        {{ $subject->nome }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Terza riga -->
    <div class="flex flex-col gap-1">
        <label class="primary-text text-sm font-medium">Argomento</label>
        <textarea name="argomento" rows="4" class="input-field w-full"></textarea>
    </div>
</form>

@endsection
