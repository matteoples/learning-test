@extends('layouts.app')

@section('page-title', 'Dettagli Lezione di ' . $lesson->student->nome . ' ' . $lesson->student->cognome)

@section('action-buttons')
<div class="flex gap-2">

    {{-- Bottone Indietro --}}
    <a href="{{ route('students.show', $lesson->student) }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        Indietro
    </a>

    {{-- Bottone Salva --}}
    <a href="{{ route('lessons.edit', $lesson) }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Modifica
    </a>

</div>
@endsection

@section('content')

<form class="flex flex-col gap-6">
    @csrf 

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Giorno --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Giorno</label>
            <input type="date" name="giorno" value="{{ $lesson->getGiornoFormatted() }}" readonly
                   class="border border-gray-200 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
        </div>

        <div class="flex flex-row gap-4">
            {{-- Ora inizio --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-sm font-medium">Ora inizio</label>
                <input type="time" name="ora_inizio" value="{{ $lesson->getOraInizioFormatted() }}" readonly
                    class="border border-gray-200 rounded-lg px-3 py-2 w-full bg-gray-100 cursor-not-allowed">
            </div>

            {{-- Ora fine --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-sm font-medium">Ora fine</label>
                <input type="time" name="ora_fine" value="{{ $lesson->getOraFineFormatted() }}" readonly
                    class="border border-gray-200 rounded-lg px-3 py-2 w-full bg-gray-100 cursor-not-allowed">
            </div>
        </div>

    </div>

    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Luogo --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Luogo</label>
            <input type="text" name="luogo" value="{{ $lesson->luogo ?? 'N/A' }}" readonly
                   class="border border-gray-200 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Materia --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Materia</label>
            <input type="text" name="luogo" value="{{ $lesson->materia ?? 'N/A' }}" readonly
                   class="border border-gray-200 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
        </div>

    </div>

    <!-- Terza riga -->
    <div>
        <label class="text-sm font-medium">Argomento</label>
        <textarea name="argomento" rows="4" readonly
                  class="border border-gray-200 rounded-lg px-3 py-2 w-full bg-gray-100 cursor-not-allowed">{{ $lesson->argomento ?? '' }}</textarea>
    </div>

</form>

@endsection
