@extends('layouts.app')

@section('page-title', 'Studenti')


@section('action-buttons')
<div class="flex items-center gap-4">
    <a href="{{ route('students.create') }}" class="primary-button px-3 py-3 sm:px-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span class="hidden sm:inline">Nuovo Studente</span>
    </a>
</div>
@endsection



@section('content')    
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-col-5 gap-4">

    @forelse($students as $student)
        <a href="{{ route('students.show', $student) }}" class="block">
            <div class="card p-4">
                <x-headline> {{ $student->getNomeCognome() }} </x-headline>
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

