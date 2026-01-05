@extends('layouts.app')

@section('page-title', 'Nuovo Studente')
@section('back-button-route', route('students.index'))


@section('action-buttons')
<div class="flex gap-2">
    <button type="submit" form="create-student-form" class="primary-button px-4 py-2">
        Salva
    </button>
</div>
@endsection


@section('content')

<form id="create-student-form" 
    action="{{ route('students.store') }}" 
    method="POST" 
    class="flex flex-col gap-6">
    @csrf

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Nome --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium"> Nome <span class="text-red-500">*</span> </label>
            <input type="text" name="nome" class="input-field" required>
        </div>
        
        {{-- Cognome --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium"> Cognome <span class="text-red-500">*</span> </label>
            <input type="text" name="cognome" class="input-field" required>
        </div>
    </div>

    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Tariffa Oraria --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Tariffa Oraria <span class="text-red-500">*</span> </label>
            <input type="number" step="0.01" name="tariffa_oraria" class="input-field">
        </div>

        {{-- Telefono --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Telefono</label>
            <input type="text" name="telefono" class="input-field">
        </div>
    </div>

    <!-- Terza riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Email --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Email</label>
            <input type="text" name="email" class="input-field">
        </div>

        {{-- Indirizzo --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Indirizzo</label>
            <input type="text" name="indirizzo" class="input-field">
        </div>
    </div>

    <!-- Quarta riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Scuola --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Scuola</label>
            <input type="text" name="scuola" class="input-field">
        </div>

        {{-- Classe --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Classe</label>
            <input type="text" name="classe" class="input-field">
        </div>
    </div>

    <!-- Note (a tutta larghezza) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Note</label>
            <textarea name="note" rows="4" class="input-field"></textarea>
        </div>
    </div>

</form>

@endsection
