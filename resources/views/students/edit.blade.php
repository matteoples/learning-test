@extends('layouts.app')

@section('page-title', 'Modifica Studente')
@section('back-button-route', route('students.show', $student))


@section('action-buttons')
<div class="flex gap-2">
    {{-- Bottone Salva (primary) --}}
    <button type="submit" form="edit-student-form" class="primary-button px-4 py-2">
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
            <label class="primary-text text-sm font-medium"> Nome <span class="text-red-500">*</span> </label>
            <input type="text" name="nome" class="input-field" required value="{{ old('nome', $student->nome) }}">
        </div>

        {{-- Cognome --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium"> Cognome <span class="text-red-500">*</span> </label>
            <input type="text" name="cognome" class="input-field" required value="{{ old('cognome', $student->cognome) }}">
        </div>
    </div>


    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Tariffa Oraria --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Tariffa Oraria <span class="text-red-500">*</span> </label>
            <input type="number" step="0.01" name="tariffa_oraria" class="input-field" value="{{ old('tariffa_oraria', $student->tariffa_oraria) }}">
        </div>

        {{-- Telefono --}} 
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Telefono</label>
            <input type="text" name="telefono" class="input-field" value="{{ old('telefono', $student->telefono) }}">                
        </div>
    </div>


    <!-- Terza riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Email --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Email</label>
            <input type="text" name="email" class="input-field" value="{{ old('email', $student->email) }}">
        </div>

        {{-- Indirizzo --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Indirizzo</label>
            <input type="text" name="indirizzo" class="input-field" value="{{ old('indirizzo', $student->indirizzo) }}">                
        </div>

    </div>


    <!-- Quarta riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Scuola --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Scuola</label>
            <input type="text" name="scuola" class="input-field" value="{{ old('scuola', $student->scuola) }}">
        </div>

        {{-- Classe --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Classe</label>
            <input type="text" name="classe" class="input-field" value="{{ old('classe', $student->classe) }}">                
        </div>
    </div>


    <!-- Note -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Note</label>
            <textarea name="note" rows="4" class="input-field">{{ old('note', $student->note) }}</textarea>
        </div>

    </div>

</form>

<div class="mt-6">
    <div class="border-t box-border mb-6"></div>
    <form action="{{ route('students.destroy', $student) }}" 
    method="POST" 
    onsubmit="return confirm('Sei sicuro di voler eliminare questo studente?');">
        @csrf
        @method('DELETE')
        <div class="flex justify-end">
            <button type="submit" class="destructive-button px-4 py-2">
            Elimina studente
        </button>
        </div>
    </form>
</div>

@endsection
