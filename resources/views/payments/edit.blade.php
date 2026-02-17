@extends('layouts.app')

@php
    $studentName = $payment->student->getNomeCompleto();
    $modalitaOptions = ['Contanti','Bonifico','PayPal','Satispay','Revolut'];
@endphp

@section('page-title')
Modifica Pagamento
<span class="hidden md:inline"> di {{ $studentName }}</span>
@endsection
@section('back-button-route', route('students.show', $payment->student))

@section('action-buttons')
<div class="flex gap-2">
    <button type="submit" form="create-payment-form" class="primary-button px-4 py-2">
        <span class="md:hidden">Salva</span>
        <span class="hidden md:inline">Salva Modifiche</span>
    </button>
</div>
@endsection

@section('content')

<form id="create-payment-form"
      action="{{ route('payments.update', $payment) }}"
      method="POST"
      class="flex flex-col gap-6">
    @csrf
    @method('PUT')


    <div class="flex flex-col md:flex-row gap-8">

        <!-- BLOCCO 1 -->
        <div class="w-full md:w-[400px] flex flex-col gap-4">
            {{-- Data --}}
            <div class="flex flex-col gap-1">
                <label class="primary-text text-sm font-medium">
                    Data <span class="text-red-500">*</span>
                </label>
                <input type="date" name="data" required value="{{ $payment->data }}" class="input-field">
            </div>
        
            {{-- Modalità --}}
            <div class="flex flex-col gap-1">
                <label class="primary-text text-sm font-medium">
                    Modalità <span class="text-red-500">*</span>
                </label>
                <select name="modalita" required class="input-field">
                    <option value="">Seleziona una modalità</option>
                    @foreach ($modalitaOptions as $mode)
                        <option value="{{ $mode }}" {{ $payment->modalita === $mode ? 'selected' : '' }}>
                            {{ $mode }}
                        </option>
                    @endforeach
                </select>
            </div>
        

            {{-- Importo --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">
                    Importo <span class="text-red-500">*</span>
                </label>
                <input type="number" name="importo" required value="{{ $payment->importo }}" class="input-field w-full">
            </div>
        
        </div>

        <!-- BLOCCO 2 -->
        {{-- Note --}}        
        <div class="w-full flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Note</label>
            <textarea name="note" rows="5" class="input-field w-full h-full">{{ $payment->note }}</textarea>
        </div>

    </div>

</form>

<div class="mt-6">
    <div class="border-t box-border mb-6"></div>

    <form action="{{ route('payments.destroy', $payment) }}"
    method="POST"
    onsubmit="return confirm('Sei sicuro di voler eliminare questo pagamento?');">
        @csrf
        @method('DELETE')
        <div class="flex justify-end">
            <button type="submit" class="destructive-button px-4 py-2">
                Elimina pagamento
            </button>
        </div>
    </form>
</div>

@endsection
