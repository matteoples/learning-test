@extends('layouts.app')

@section('page-title', 'Studenti')


@section('action-buttons')
<div class="flex items-center gap-4">
    <a href="{{ route('students.create') }}">
        <x-button icon="add">
            <x-text class="hidden sm:inline"> Nuovo Studente </x-text>
        </x-button>
    </a>
</div>
@endsection



@section('content')    
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-col-5 gap-4">

    @forelse($students as $student)
        <a href="{{ route('students.show', $student) }}" class="block">
            
            <x-box-container>
                <x-headline> {{ $student->getNomeCognome() }} </x-headline>
                <x-label> Classe: {{ $student->classe ?? '-' }} </x-label>
            </x-box-container>
            
        </a>
    @empty
        <x-label class="text-center"> Non ci sono studenti da mostrare </x-label>
    @endforelse

</div>
@endsection

