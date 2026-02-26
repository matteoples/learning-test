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
        
        {{-- ANAGRAFICA --}}
        <x-box-container>
            <div class="flex justify-between items-center">
                <x-title> Anagrafica</x-title>
                <x-button href="{{ route('students.edit', $student) }}" 
                    variant="primary" icon="edit"> Modifica </x-button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-2 gap-4 mt-4">
                <x-labeled-content label="Nome"             value="{{ $student->nome }}"                direction="column"/>
                <x-labeled-content label="Cognome"          value="{{ $student->cognome }}"             direction="column"/>
                <x-labeled-content label="Telefono"         value="{{ $student->telefono }}"            direction="column"/>
                <x-labeled-content label="Tariffa Oraria"   value="€ {{ $student->tariffa_oraria }}"    direction="column"/>
                <x-labeled-content label="Email"            value="{{ $student->email }}"               direction="column"/>
                <x-labeled-content label="Indirizzo"        value="{{ $student->indirizzo }}"           direction="column"/>
                <x-labeled-content label="Scuola"           value="{{ $student->scuola }}"              direction="column"/>
                <x-labeled-content label="Classe"           value="{{ $student->classe }}"              direction="column"/>
                <x-labeled-content label="Note"             value="{{ $student->note }}"                direction="column"/>
            </div>
        </x-box-container>

        {{-- SEZIONE PAGAMENTI --}}
        <x-box-container>
            <div class="flex justify-between items-center">
                <x-title> Pagamenti</x-title>
                <x-button href="{{ route('payments.create', $student) }}" 
                    variant="primary" icon="add"> Nuovo </x-button>
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
                    <div class="p-4">
                        <x-label> Non ci sono pagamenti per questo studente da mostrare. </x-label>
                    </div>
                @endforelse
            </div>
        </x-box-container>


    </div>

    <div class="flex flex-col w-full gap-4">
        {{-- SEZIONE STATISTICHE --}}
        <div class="flex flex-col md:flex-row gap-4">
            <x-box-container class="flex-1">
                <div class="flex justify-between">
                    <p class="primary-text font-medium">Totale pagamenti</p>
                    <p class="primary-text"> € {{ $student->getTotalPayments() }} </p>
                </div>

                <div class="flex justify-between">
                    <p class="primary-text font-medium">Totale ore fatte</p>
                    <p class="primary-text"> € {{ $student->getTotalLessonsFormatted() }} </p>
                </div>
            </x-box-container>

            <x-box-container class="flex-1">
                <div class="flex justify-between">
                    <p class="primary-text font-medium">
                        Importo @if ($student->saldo() > 0) Credito @else Debito @endif
                    </p>
                
                    <p class="primary-text"> € {{abs($student->saldo())}} </p>
                </div>

                <div class="flex justify-between">
                    <p class="primary-text font-medium">
                        Ore di @if ($student->saldo() > 0) Credito @else Debito @endif
                    </p>

                    <p class="primary-text"> {{$student->saldoOrarioFormatted() }} </p>
                </div>

                <x-label> L'addebito dell'ora avviene al momento della prenotazione.</x-label>
            </x-box-container>
        </div>


        {{-- SEZIONE LEZIONI --}}
        <x-box-container>
            <div class="flex flex-col gap-4 h-full">
                <div class="flex justify-between items-center">
                    <x-title> Lezioni</x-title>

                    <x-button href="{{ route('lessons.create', $student) }}" 
                    variant="primary" icon="add"> Nuova </x-button>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                    @forelse ($student->lessons as $lesson)
                        <a href="{{ route('lessons.show', $lesson) }}" class="block h-full">
                            <div class="card p-3 h-full">
                                <div class="flex justify-between items-center mb-1">
                                    <p class="secondary-text text-xs">{{ $lesson->getTextGiornoFormatted() }}</p>
                                    <p class="primary-text font-large"> {{ $lesson->getDurataFormatted() }}</p>
                                </div>
                                <div class="pr-5 flex-1">
                                    <p class="primary-text font-medium">{{ $lesson->subject->nome  ?? "N/A" }}</p>
                                    @isset($lesson->argomento)
                                        <p class="secondary-text text-xs">{{ $lesson->argomento}}</p>
                                    @endisset
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-4">
                            <x-label> Non ci sono lezioni per questo studente da mostrare. </x-label>
                        </div>
                    @endforelse
                </div>
            </div>
        </x-box-container>
    </div>


</div>







@endsection
