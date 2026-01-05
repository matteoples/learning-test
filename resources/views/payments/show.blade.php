@extends('layouts.app')

@php
    $studentName = $payment->student->getNomeCompleto();
@endphp

@section('page-title')
Pagamento
<span class="hidden md:inline"> di {{ $studentName }}</span>
@endsection
@section('back-button-route', route('students.show', $payment->student))

@section('action-buttons')
<div class="flex gap-2">
    <a href="{{ route('payments.edit', $payment) }}" class="primary-button px-4 py-2">
        Modifica
    </a>
</div>
@endsection

@section('content')
<div class="flex flex-col gap-6">
    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Data --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Data</label>
            <input type="date" value="{{ $payment->data }}" readonly class="input-field" />
        </div>

        <div class="flex flex-row gap-4">
            {{-- Importo --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">Importo</label>
                <input type="number" value="{{ $payment->importo }}" readonly class="input-field w-full" />
            </div>

            {{-- Numero ore --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">Numero Ore</label>
                <input type="number" step="0.25" value="{{ $payment->numero_ore }}" readonly class="input-field w-full" />
            </div>
        </div>
    </div>

    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Modalità --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Modalità</label>
            <input type="text" value="{{ $payment->modalita }}" readonly class="input-field" />
        </div>
    </div>

    <!-- Note -->
    <div class="flex flex-col gap-1">
        <label class="primary-text text-sm font-medium">Note</label>
        <textarea rows="4" readonly class="input-field w-full">{{ $payment->note }}</textarea>
    </div>

</div>

@endsection
