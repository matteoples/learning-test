@extends('layouts.app')

@php
    $studentName = $payment->student->getNomeCognome();
    use App\Enums\FontWeight as FW;
@endphp

@section('page-title')
Pagamento <span class="hidden md:inline"> di {{ $studentName }}</span>
@endsection
@section('back-button-route', route('students.show', $payment->student))

@section('action-buttons')

<div class="flex gap-2">
    <a href="{{ route('payments.edit', $payment) }}">
        <x-button> Modifica </x-button>
    </a>
</div>
@endsection

@section('content')

<div class="flex flex-col md:flex-row gap-8">

    <!-- BLOCCO 1 -->
    <div class="w-full md:w-[400px] flex flex-col gap-4">
        {{-- Data --}}
        <div class="flex flex-col gap-1">
            <x-label color="var(--primary-text)" :weight="FW::Semibold"> Data <span class="text-red-500">*</span> </x-label>
            <x-input-field type="date" :value="$payment->data" mode="readonly"/>
        </div>

        {{-- Modalità --}}
        <div class="flex flex-col gap-1">
            <x-label color="var(--primary-text)" :weight="FW::Semibold"> Modalità <span class="text-red-500">*</span> </x-label>
            <x-input-field type="text" :value="$payment->modalita" mode="readonly"/>
        </div>


        {{-- Importo --}}
        <div class="flex flex-col gap-1">
            <x-label color="var(--primary-text)" :weight="FW::Semibold"> Importo <span class="text-red-500">*</span> </x-label>
            <x-input-field type="number" :value="$payment->importo" mode="readonly"/>
        </div>
    </div>

    <!-- BLOCCO 2 -->
    {{-- Note --}}
    <div class="w-full flex flex-col gap-1">
        <x-label color="var(--primary-text)" :weight="FW::Semibold"> Note </x-label>
        <textarea rows="5" disabled readonly class="input-field w-full h-full">
            {{ $payment->note }}
        </textarea>
    </div>
</div>



@endsection
