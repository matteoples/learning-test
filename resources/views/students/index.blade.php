@extends('layouts.app')

@section('page-title', 'Studenti')


@section('action-buttons')
<div class="flex items-center gap-4">
    {{-- <a href="{{ route('students.import.form') }}" class="primary-button opacity-50 pointer-events-none">
        Importa da JSON
    </a> --}}

    {{-- Primary Button --}}
{{--     <a href="{{ route('students.create') }}" class="primary-button px-4 py-2">
        <img src="{{ asset('img/add.png') }}" alt="Aggiungi" class="w-4 h-4">
        Nuovo Studente
    </a> --}}

    <form action="{{ route('google.sync') }}" method="POST">
        @csrf
        <button type="submit"
            class="primary-button px-3 py-3 sm:px-4 flex items-center gap-2">
            Sincronizza Google Calendar
        </button>
    </form>

    <a href="{{ route('students.create') }}" class="primary-button px-3 py-3 sm:px-4 flex items-center gap-2">
        <img src="{{ asset('img/add.png') }}" alt="Aggiungi" class="w-4 h-4">
        <span class="hidden sm:inline">Nuovo Studente</span>
    </a>

    
</div>
@endsection



@section('content')    
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-col-5 gap-4">

    @forelse($students as $student)
        <a href="{{ route('students.show', $student) }}" class="block">
            <div class="card p-4">
                <h3 class="primary-text text-lg font-semibold">{{ $student->nome }} {{ $student->cognome }}</h3>
                <p class="secondary-text text-sm mt-1">Classe: {{ $student->classe ?? '-' }}</p>
            </div>
        </a>
    @empty
        <p class="secondary-text col-span-full text-center py-10">
            Non ci sono studenti da mostrare.
        </p>
    @endforelse

</div>
@endsection

