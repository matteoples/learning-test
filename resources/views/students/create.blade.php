@extends('layouts.app')

@section('page-title', 'Nuovo Studente')
@section('back-button-route', route('students.index'))


@section('action-buttons')
<div class="flex gap-2">
    {{-- Bottone Salva (primary) --}}
    <button type="submit" form="create-student-form"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Salva
    </button>

</div>
@endsection


@section('content')

<form id="create-student-form" action="{{ route('students.store') }}" method="POST" class="flex flex-col gap-6">
    @csrf

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Nome --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">
                Nome <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nome" required
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>
        
        {{-- Cognome --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">
                Cognome <span class="text-red-500">*</span>
            </label>
            <input type="text" name="cognome" required
                class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>
    </div>

    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Data di nascita --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Data di nascita</label>
            <input type="date" name="data_nascita"
                   class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Telefono --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Telefono</label>
            <input type="text" name="telefono"
                   class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>
    </div>

    <!-- Terza riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Email --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Email</label>
            <input type="email" name="email"
                   class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Indirizzo --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Indirizzo</label>
            <input type="text" name="indirizzo"
                   class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>
    </div>

    <!-- Quarta riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Scuola --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Scuola</label>
            <input type="text" name="scuola"
                   class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Classe --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Classe</label>
            <input type="text" name="classe"
                   class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>
    </div>

    <!-- Note (a tutta larghezza) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Nota --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Note</label>
            <textarea name="note" rows="4"
                  class="border border-gray-200 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-200 focus:outline-none"></textarea>
        </div>
    </div>

</form>

@endsection
