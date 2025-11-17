@extends('layouts.app')

@section('page-title', 'Studenti')


@section('action-buttons')
<div class="flex items-center gap-2">

    {{-- Secondary Button --}}
    <a href="{{ route('students.create') }}"
        class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        Esporta JSON
    </a>

    {{-- Primary Button --}}
    <a href="{{ route('students.create') }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Nuovo
    </a>

</div>
@endsection



@section('content')    
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">

    @forelse($students as $student)
        <a href="{{ route('students.show', $student) }}" class="block">
            <div class="bg-[#FDFDFC] dark:bg-[#161615] p-4 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200">
                <h3 class="text-lg font-semibold">{{ $student->nome }} {{ $student->cognome }}</h3>
                <p class="text-sm mt-1">Classe: {{ $student->classe ?? '-' }}</p>
            </div>
        </a>
    @empty
        <p class="col-span-full text-center text-gray-500 py-10">
            Non ci sono studenti da mostrare.
        </p>
    @endforelse

</div>
@endsection

