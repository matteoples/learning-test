@extends('layouts.app')

@section('page-title', 'Dettagli Studente')
@section('back-button-route', route('students.index'))

@section('action-buttons')
<div class="flex gap-2">
    {{-- Esporta --}}
    <a href="#" class="primary-button px-4 py-2 opacity-50 pointer-events-none">
        Esporta dati
    </a>

</div>
@endsection

@section('content')

<div class="flex gap-4">
    <div class="flex flex-col gap-4 w-[35%]">

        <div class="section">
            <div class="flex justify-between items-center">
                <h2 class="primary-text text-xl font-semibold">Anagrafica</h2>
                <a href="{{ route('students.edit', $student) }}" class="primary-button px-3 py-3">
                    <img src="{{ asset('img/edit.png') }}" alt="Modifica" class="w-5 h-5">
                </a>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                {{-- Nome --}}
                <div>
                    <p class="secondary-text text-sm">Nome</p>
                    <p class="primary-text font-medium">{{ $student->nome }}</p>
                </div>

                {{-- Cognome --}}
                <div>
                    <p class="secondary-text text-sm">Cognome</p>
                    <p class="primary-text font-medium">{{ $student->cognome }}</p>
                </div>

                {{-- Data di nascita --}}
                <div>
                    <p class="secondary-text text-sm">Data di nascita</p>
                    <p class="primary-text font-medium">{{ $student->getDataDiNascitaFormatted() ?? '-' }}</p>
                </div>

                {{-- Telefono --}}
                <div>
                    <p class="secondary-text text-sm">Telefono</p>
                    <p class="primary-text font-medium">{{ $student->telefono ?? '-' }}</p>
                </div>

                {{-- Email --}}
                <div>
                    <p class="secondary-text text-sm">Email</p>
                    <p class="primary-text font-medium">{{ $student->email ?? '-' }}</p>
                </div>

                {{-- Indirizzo --}}
                <div>
                    <p class="secondary-text text-sm">Indirizzo</p>
                    <p class="primary-text font-medium">{{ $student->indirizzo ?? '-' }}</p>
                </div>

                {{-- Scuola --}}
                <div>
                    <p class="secondary-text text-sm">Scuola</p>
                    <p class="primary-text font-medium">{{ $student->scuola ?? '-' }}</p>
                </div>

                {{-- Classe --}}
                <div>
                    <p class="secondary-text text-sm">Classe</p>
                    <p class="primary-text font-medium">{{ $student->classe ?? '-' }}</p>
                </div>

                {{-- Note (a tutta larghezza) --}}
                <div class="md:col-span-2">
                    <p class="secondary-text">Note</p>
                    <p class="primary-text font-medium">{{ $student->note ?? '-' }}</p>
                </div>

            </div>
        </div>

        <div class="section">
            <div class="flex justify-between items-center">
                <h2 class="primary-text text-xl font-semibold">Pagamenti</h2>

                <a href="{{ route('payments.create', $student) }}" class="primary-button px-3 py-3">
                    <img src="{{ asset('img/add.png') }}" alt="Aggiungi" class="w-4 h-4">
                </a>
            </div>
            
            <div class="grid grid-cols-1 gap-3">
                @forelse ($student->payments as $payment)
                    <a href="{{ route('payments.show', $payment) }}" class="block h-full">
                        <div class="card p-3 h-full">
                            <div class="flex justify-between items-center">
                                <p class="secondary-text text-xs">{{ $payment->getTextGiornoFormatted() }}</p>
                                <p class="primary-text font-medium">€ {{ $payment->importo }}</p>
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
        <div class="section p-6 flex flex-col gap-4 h-full">
            <div class="flex justify-between items-center">
                <h2 class="primary-text text-xl font-semibold">Lezioni</h2>

                <a href="{{ route('lessons.create', $student) }}"
                class="primary-button px-4 py-2">
                    <img src="{{ asset('img/add.png') }}" alt="Aggiungi" class="w-3 h-3">
                    Nuova lezione
                </a> 
            </div>


            <div class="grid grid-cols-2 xl:grid-cols-3 gap-3">
                @forelse ($student->lessons as $lesson)
                    <a href="{{ route('lessons.show', $lesson) }}" class="block h-full">
                        <div class="card p-3 h-full">
                            <div class="flex justify-between items-center mb-1">
                                <p class="secondary-text text-xs">{{ $lesson->getTextGiornoFormatted() }}</p>
                                <p class="primary-text font-large"> {{ $lesson->durata() }} h</p>
                            </div>
                            <div class="pr-5 flex-1">
                                <p class="primary-text font-medium">{{ $lesson->materia  ?? "N/A" }}</p>
                                @isset($lesson->argomento)
                                    <p class="secondary-text text-xs">{{ $lesson->argomento}}</p>
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
