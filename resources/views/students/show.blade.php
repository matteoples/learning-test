@php
use App\Enums\FontWeight as FW;
@endphp

@extends('layouts.app')

@section('page-title', 'Dettagli Studente')
@section('back-button-route', route('students.index'))

@section('action-buttons')
<div class="flex gap-2">
    {{-- Esporta --}}
    {{-- <a href="#" class="primary-button px-4 py-2 opacity-50 pointer-events-none">
        Esporta dati
    </a> --}}

</div>
@endsection

@section('content')

<div class="flex flex-col lg:flex-row gap-4">
    <div class="flex flex-col gap-4 w-full lg:w-[40%]">
        
        {{-- ANAGRAFICA --}}
        <x-box-container size="large">
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
        <x-box-container size="large">
            <div class="flex justify-between items-center">
                <x-title> Pagamenti</x-title>
                <x-button href="{{ route('payments.create', $student) }}" 
                    variant="primary" icon="add"> Nuovo </x-button>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3">
                @forelse ($student->payments as $payment)
                    <a href="{{ route('payments.show', $payment) }}" class="block h-full">
                        <x-box-container>
                            <x-key-value-pair>
                                <x-slot name="key">
                                    <x-text> {{ $payment->getTextGiornoFormatted() }} </x-text>
                                </x-slot>

                                <x-slot name="value">
                                    <x-headline :weight="FW::Bold"> € {{ (int) $payment->importo }} </x-headline>
                                </x-slot>
                            </x-key-value-pair>
                        </x-box-container>
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
                <x-key-value-pair>
                    <x-slot name="key">
                        <x-text> Totale pagamenti </x-text>
                    </x-slot>

                    <x-slot name="value">
                        <x-text :weight="FW::Semibold"> € {{ $student->getTotalPayments() }} </x-text>
                    </x-slot>
                </x-key-value-pair>

                <x-key-value-pair>
                    <x-slot name="key">
                        <x-text> Totale ore fatte </x-text>
                    </x-slot>

                    <x-slot name="value">
                        <x-text :weight="FW::Semibold"> {{ $student->getTotalLessonsFormatted() }} </x-text>
                    </x-slot>
                </x-key-value-pair>
            </x-box-container>

            <x-box-container class="flex-1">
                <x-key-value-pair>
                    <x-slot name="key">
                        <x-text> Importo @if ($student->saldo() > 0) Credito @else Debito @endif </x-text>
                    </x-slot>

                    <x-slot name="value">
                        <x-text :weight="FW::Semibold"> € {{abs($student->saldo())}} </x-text>
                    </x-slot>
                </x-key-value-pair>

                <x-key-value-pair>
                    <x-slot name="key">
                        <x-text> Ore di @if ($student->saldo() > 0) Credito @else Debito @endif </x-text>
                    </x-slot>

                    <x-slot name="value">
                        <x-text :weight="FW::Semibold"> {{ $student->saldoOrarioFormatted() }} </x-text>
                    </x-slot>
                </x-key-value-pair>

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


                <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-3">
                    @forelse ($student->lessons as $lesson)
                        <a href="{{ route('lessons.show', $lesson) }}" class="block h-full">

                            <x-box-container class="h-full">
                                <div class="flex justify-between items-center">
                                    <x-label> {{ $lesson->getTextGiornoFormatted() }} - {{ $lesson->getOraInizioFormatted() }} : {{ $lesson->getOraFineFormatted() }}</x-label>
                                    <x-text> {{ $lesson->getDurataFormatted() }} </x-text>
                                </div>
                                <div class="pr-5 flex-1">
                                    <x-headline>{{ $lesson->subject->nome  ?? "N/A" }}</x-headline>
                                    <x-text> {{ $lesson->argomento }} </x-text>
                                </div>
                            </x-box-container>
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
