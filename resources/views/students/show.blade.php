@extends('layouts.app')

@section('page-title', 'Dettagli Studente')

@section('action-buttons')
<div class="flex gap-2">
    {{-- Torna alla lista --}}
    <a href="{{ route('students.index') }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        Indietro
    </a>

    {{-- Modifica --}}
    <a href="{{ route('students.edit', $student) }}"
{{--        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
 --}}        class="px-4 py-2 bg-blue-600 text-white rounded-lg opacity-50 pointer-events-none">
        Esporta Dati
    </a>
</div>
@endsection

@section('content')

<div class="flex gap-4">

    
    <div class="flex flex-col gap-4 w-[35%]">
        <div class="bg-white border border-gray-200 rounded-[12px] p-6 flex flex-col gap-4">

            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Anagrafica</h2>
                <a href="{{ route('students.edit', $student) }}"
                class="px-3 py-3 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center justify-center">
                    <img src="{{ asset('img/edit.png') }}" alt="Modifica" class="w-5 h-5">
                </a>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                {{-- Nome --}}
                <div>
                    <p class="text-gray-500 text-sm">Nome</p>
                    <p class="font-medium">{{ $student->nome }}</p>
                </div>

                {{-- Cognome --}}
                <div>
                    <p class="text-gray-500 text-sm">Cognome</p>
                    <p class="font-medium">{{ $student->cognome }}</p>
                </div>

                {{-- Data di nascita --}}
                <div>
                    <p class="text-gray-500 text-sm">Data di nascita</p>
                    <p class="font-medium">{{ $student->data_nascita ? $student->data_nascita->format('d/m/Y') : '-' }}</p>
                </div>

                {{-- Telefono --}}
                <div>
                    <p class="text-gray-500 text-sm">Telefono</p>
                    <p class="font-medium">{{ $student->telefono ?? '-' }}</p>
                </div>

                {{-- Email --}}
                <div>
                    <p class="text-gray-500 text-sm">Email</p>
                    <p class="font-medium">{{ $student->email ?? '-' }}</p>
                </div>

                {{-- Indirizzo --}}
                <div>
                    <p class="text-gray-500 text-sm">Indirizzo</p>
                    <p class="font-medium">{{ $student->indirizzo ?? '-' }}</p>
                </div>

                {{-- Scuola --}}
                <div>
                    <p class="text-gray-500 text-sm">Scuola</p>
                    <p class="font-medium">{{ $student->scuola ?? '-' }}</p>
                </div>

                {{-- Classe --}}
                <div>
                    <p class="text-gray-500 text-sm">Classe</p>
                    <p class="font-medium">{{ $student->classe ?? '-' }}</p>
                </div>

                {{-- Note (a tutta larghezza) --}}
                <div class="md:col-span-2">
                    <p class="text-gray-500 text-sm">Note</p>
                    <p class="font-medium">{{ $student->note ?? '-' }}</p>
                </div>

            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-[12px] p-6 flex flex-col gap-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Pagamenti</h2>

                <a href="{{ route('payments.create', $student) }}"
                class="px-3 py-3 bg-blue-600 border border-gray-200 rounded-lg text-gray-700 hover:bg-blue-700 transition flex items-center justify-center">
                    <img src="{{ asset('img/add.png') }}" alt="Aggiungi" class="w-4 h-4">
                </a>
            </div>
            
            <div class="grid grid-cols-1 gap-3">
                @forelse ($student->payments as $payment)
                    <a href="{{ route('payments.show', $payment) }}" class="block h-full">
                        <div class="bg-[#FDFDFC] dark:bg-[#161615] p-3 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200 flex flex-col h-full">
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-xs">{{ $payment->getTextGiornoFormatted() }}</p>
                                <p class="font-medium">€ {{ $payment->importo }}</p>
                            </div>
                        </div>
                    </a>

                @empty
                    <p class="col-span-full text-center text-gray-500 py-10">
                        Non ci sono pagamenti per questo studente da mostrare.
                    </p>
                @endforelse
            </div>


        </div>
    </div>

    <div class="flex flex-col w-full">
        <div class="bg-white border border-gray-200 rounded-[12px] p-6 flex flex-col gap-4 h-full">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Lezioni</h2>

                <a href="{{ route('lessons.create', $student) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <img src="{{ asset('img/add.png') }}" alt="Aggiungi" class="w-4 h-4">
                    Nuovo
                </a>

                
            </div>


            <div class="grid grid-cols-2 xl:grid-cols-3 gap-3">
                @forelse ($student->lessons as $lesson)
                    <a href="{{ route('lessons.show', $lesson) }}" class="block h-full">
                        <div class="bg-[#FDFDFC] dark:bg-[#161615] p-3 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200 flex flex-col h-full">
                            <div class="flex justify-between items-center mb-1">
                                <p class="text-gray-500 text-xs">{{ $lesson->getTextGiornoFormatted() }}</p>
                                <p class="font-large"> {{ $lesson->durata() }} h</p>
                            </div>
                            <div class="pr-5 flex-1">
                                <p class="font-medium">{{ $lesson->materia  ?? "N/A" }}</p>
                                @isset($lesson->argomento)
                                    <p class="text-gray-500 text-xs">{{ $lesson->argomento}}</p>
                                @endisset
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-500 py-10">
                        Non ci sono lezioni per questo studente da mostrare.
                    </p>
                @endforelse
            </div>
        </div>
    </div>


</div>







@endsection
