@extends('layouts.app')

@php
    use App\Enums\FontWeight as FW;
    $studentName = $student->getNomeCognome();
    $modalitaOptions = ['Contanti','Bonifico','PayPal','Satispay','Revolut'];
@endphp

@section('page-title')
Nuovo Pagamento <span class="hidden md:inline"> per {{ $studentName }}</span>
@endsection
@section('back-button-route', route('students.show', $student))

@section('action-buttons')
<x-button type="submit" form="create-payment-form"> 
    <span class="md:hidden">Aggiungi</span>
    <span class="hidden md:inline">Aggiungi Pagamento</span>
</x-button>
@endsection


@section('content')

<form id="create-payment-form"
    action="{{ route('payments.store', $student) }}"
    method="POST"
    class="flex flex-col gap-6">
    @csrf

    <div class="flex flex-col md:flex-row gap-8">

        <!-- BLOCCO 1 -->
        <div class="w-full md:w-[400px] flex flex-col gap-4">
            {{-- Data --}}

            <div class="flex flex-col gap-1">
                <label class="primary-text text-sm font-medium">
                    Data <span class="text-red-500">*</span>
                </label>
                <input type="date" name="data"  value="{{ now()->format('Y-m-d') }}" class="input-field">
            </div>
        
            {{-- Modalità --}}
            <div class="flex flex-col gap-1">
                <label class="primary-text text-sm font-medium">
                    Modalità <span class="text-red-500">*</span>
                </label>
                <select name="modalita" required class="input-field">
                    <option value="">Seleziona una modalità</option>
                    @foreach ($modalitaOptions as $mode)
                        <option value="{{ $mode }}">
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
                <input type="number" name="importo" required class="input-field w-full">
            </div>
        
        </div>

        <!-- BLOCCO 2 -->
        {{-- Note --}}        
        <div class="w-full flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Note</label>
            <textarea name="note" rows="5" class="input-field w-full h-full"></textarea>
        </div>

    </div>

</form>

@endsection
