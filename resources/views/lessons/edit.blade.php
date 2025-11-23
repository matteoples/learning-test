@extends('layouts.app')

@section('page-title', 'Modifica Lezione di ' . $lesson->student->getNomeCompleto())
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
            <input type="text" name="luogo" value="{{ $lesson->luogo ?? '' }}" class="input-field" />
        </div>

        {{-- Materia --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Materia</label>
            <select name="materia" class="input-field">
                <option value="">Seleziona una materia</option>
                <option value="Matematica" @selected($lesson->materia === 'Matematica')>Matematica</option>
                <option value="Telecomunicazioni" @selected($lesson->materia === 'Telecomunicazioni')>Telecomunicazioni</option>
                <option value="Informatica" @selected($lesson->materia === 'Informatica')>Informatica</option>
                <option value="Chimica" @selected($lesson->materia === 'Chimica')>Chimica</option>
                <option value="Inglese" @selected($lesson->materia === 'Inglese')>Inglese</option>
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
