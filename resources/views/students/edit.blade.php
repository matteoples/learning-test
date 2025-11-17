@extends('layouts.app')

@section('title', 'Modifica Studente')
@section('page-title', 'Modifica Studente')

@section('action-buttons')
<div class="flex gap-2">

    {{-- Bottone Annulla (secondary) --}}
    <a href="{{ route('students.show', $student) }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
       Annulla
    </a>

    {{-- Bottone Salva (primary) --}}
    <button type="submit" form="edit-student-form"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Salva
    </button>

</div>
@endsection


@section('content')

<form id="edit-student-form"
      action="{{ route('students.update', $student) }}"
      method="POST"
      class="flex flex-col gap-6">

    @csrf
    @method('PUT')

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Nome --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">
                Nome <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nome" value="{{ old('nome', $student->nome) }}" required
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Cognome --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">
                Cognome <span class="text-red-500">*</span>
            </label>
            <input type="text" name="cognome" value="{{ old('cognome', $student->cognome) }}" required
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

    </div>


    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Data di nascita --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Data di nascita</label>
            <input type="date" name="data_nascita"
                value="{{ old('data_nascita', $student->data_nascita) }}"
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Telefono --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Telefono</label>
            <input type="text" name="telefono"
                value="{{ old('telefono', $student->telefono) }}"
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

    </div>


    <!-- Terza riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Email --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Email</label>
            <input type="email" name="email"
                value="{{ old('email', $student->email) }}"
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Indirizzo --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Indirizzo</label>
            <input type="text" name="indirizzo"
                value="{{ old('indirizzo', $student->indirizzo) }}"
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

    </div>


    <!-- Quarta riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Scuola --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Scuola</label>
            <input type="text" name="scuola"
                value="{{ old('scuola', $student->scuola) }}"
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Classe --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Classe</label>
            <input type="text" name="classe"
                value="{{ old('classe', $student->classe) }}"
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

    </div>


    <!-- Note -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Note</label>
            <textarea name="note" rows="4"
                class="border border-gray-200 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">{{ old('note', $student->note) }}</textarea>
        </div>

    </div>

</form>

@endsection
