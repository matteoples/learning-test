@extends('layouts.app')

@php
    $studentName = $payment->student->getNomeCognome();
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
            <label class="primary-text text-sm font-medium">
                Data <span class="text-red-500">*</span>
            </label>
            <input type="date" value="{{ $payment->data }}" readonly class="input-field" />
        </div>

        {{-- Modalità --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">
                Modalità <span class="text-red-500">*</span>
            </label>
            <input type="text" value="{{ $payment->modalita }}" readonly class="input-field" />
        </div>

        {{-- Importo --}}
        <div class="flex flex-col gap-1 flex-1">
            <label class="primary-text text-sm font-medium">
                Importo <span class="text-red-500">*</span>
            </label>
            <input type="number" value="{{ $payment->importo }}" readonly class="input-field" />
        </div>
    </div>

    <!-- BLOCCO 2 -->
    {{-- Note --}}
    <div class="w-full flex flex-col gap-1">
        <label class="primary-text text-sm font-medium">Note</label>
        <textarea rows="5" readonly class="input-field w-full h-full">
            {{ $payment->note }}
        </textarea>
    </div>

</div>



@endsection
