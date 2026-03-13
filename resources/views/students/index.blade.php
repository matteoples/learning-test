@extends('layouts.app')

@section('page-title', 'Studenti')


@section('action-buttons')
<div class="flex items-center gap-4">
    <x-button href="{{ route('students.create') }}" icon="add">
        <span class="hidden sm:inline">Nuovo Studente</span>
    </x-button>
</div>
@endsection



@section('content')    
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-col-5 gap-4">

    @forelse($students as $student)
        <a href="{{ route('students.show', $student) }}" class="block">
            
            <x-card clickable>
                <x-headline> {{ $student->getNomeCognome() }} </x-headline>
                <x-label> Classe: {{ $student->classe ?? '-' }} </x-label>
            </x-card>
            
        </a>
    @empty
        <x-label class="text-center"> Non ci sono studenti da mostrare </x-label>
    @endforelse

</div>
@endsection

