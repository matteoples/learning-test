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

<div class="flex flex-col lg:flex-row gap-4">
    <div class="flex flex-col gap-4 w-full lg:w-[40%]">
        <div class="section">
            <div class="flex justify-between items-center">
                <h2 class="primary-text text-xl font-semibold">Anagrafica</h2>
                <a href="{{ route('students.edit', $student) }}" class="primary-button px-3 py-3">
                    <div class="items-center flex gap-3">
                        <img src="{{ asset('img/edit.png') }}" alt="Modifica" class="w-5 h-5">
                        <p class="hidden sm:inline lg:hidden 2xl:inline">Modifica</p> <!-- Nasconde il testo su sm e xs -->
                    </div>
                </a>
            </div>

            
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-2 gap-4 mt-4">
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

                {{-- Telefono --}}
                <div>
                    <p class="secondary-text text-sm">Telefono</p>
                    <p class="primary-text font-medium">{{ $student->telefono ?? '-' }}</p>
                </div>

                {{-- Tariffa Oraria --}}
                <div>
                    <p class="secondary-text text-sm">Tariffa Oraria</p>
                    <p class="primary-text font-medium">€ {{ $student->tariffa_oraria ?? '-' }}</p>
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
                    <div class="items-center flex gap-3">
                        <img src="{{ asset('img/add.png') }}" alt="Aggiungi" class="w-4 h-4">
                        <p class="hidden sm:inline lg:hidden 2xl:inline">Aggiungi</p> <!-- Nasconde il testo su sm e xs -->
                    </div>
                    
                </a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3">
                @forelse ($student->payments as $payment)
                    <a href="{{ route('payments.show', $payment) }}" class="block h-full">
                        <div class="card p-3 h-full">
                            <div class="flex justify-between items-center">
                                <p class="secondary-text text-xs">{{ $payment->getTextGiornoFormatted() }}</p>
                                <p class="primary-text font-medium">€ {{ (int) $payment->importo }}</p>
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

    <div class="flex flex-col w-full gap-4">
        <div class="flex flex-col md:flex-row gap-4">

            <div class="section w-full">
                <div class="flex justify-between">
                    <p class="primary-text font-medium">Totale pagamenti</p>
                    <p class="primary-text"> € {{ $student->getTotalPayments() }} </p>
                </div>
                <div class="flex justify-between">
                    <p class="primary-text font-medium">Totale ore fatte</p>
                    <p class="primary-text"> {{ $student->getTotalLessonsFormatted() }} </p>
                </div>
            </div>

            <div class="section w-full">
                <div class="flex justify-between">
                    <p class="primary-text font-medium">
                        Importo
                        @if ($student->saldo() > 0)
                            Credito
                        @else
                            Debito
                        @endif
                    </p>

                    <p class="primary-text">
                        € {{abs($student->saldo())}}
                    </p>
                </div>

                <div class="flex justify-between">
                    <p class="primary-text font-medium">
                        Ore di
                        @if ($student->saldo() > 0)
                            Credito
                        @else
                            Debito
                        @endif
                    </p>

                    <p class="primary-text">
                        {{ $student->saldoOrarioFormatted() }}
                    </p>
                </div>

                <p class="text-xs text-gray-500"> L'addebito dell'ora avviene al momento della prenotazione.</p>
            </div>
        </div>

        <div class="section p-6 flex flex-col gap-4 h-full">
            <div class="flex justify-between items-center">
                <h2 class="primary-text text-xl font-semibold">Lezioni</h2>

                <a href="{{ route('students.edit', $student) }}" class="primary-button px-3 py-3">
                    <div class="items-center flex gap-3">
                        <img src="{{ asset('img/add.png') }}" alt="Modifica" class="w-5 h-5">
                        <p class="hidden sm:inline">Aggiungi </p> <!-- Nasconde il testo su sm e xs -->
                    </div>
                </a>
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
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
