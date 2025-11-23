@extends('layouts.app')

@section('page-title', 'Nuova Lezione di ' . $student->getNomeCompleto())
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
            <input type="text" name="luogo" class="input-field">
        </div>

        {{-- Materia --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Materia</label>
            <select name="materia" class="input-field">
                <option value="">Seleziona una materia</option>
                <option value="Matematica">Matematica</option>
                <option value="Telecomunicazioni">Telecomunicazioni</option>
                <option value="Informatica">Informatica</option>
                <option value="Chimica">Chimica</option>
                <option value="Inglese">Inglese</option>
                {{-- aggiungi altre materie qui --}}
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
