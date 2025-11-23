@extends('layouts.app')

@section('page-title', 'Nuovo Pagamento per ' . $student->getNomeCompleto())
@section('back-button-route', route('students.show', $student))


@section('action-buttons')
<div class="flex gap-2">
    {{-- Bottone Salva --}}
    <button type="submit" form="create-payment-form" class="primary-button px-4 py-2">
        Salva
    </button>
</div>
@endsection


@section('content')

<form id="create-payment-form"
    action="{{ route('payments.store', $student) }}"
    method="POST"
    class="flex flex-col gap-6">
    @csrf

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Giorno --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Data <span class="text-red-500">*</span></label>
            <input type="date" name="data" class="input-field" required value="{{ now()->format('Y-m-d') }}">
        </div>

        <div class="flex flex-row gap-4">
            {{-- Importo --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium"> Importo <span class="text-red-500">*</span></label>
                <input type="number" name="importo" class="input-field" required>
            </div>

            {{-- Numero  ore --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">Numero Ore <span class="text-red-500">*</span></label>
                <input type="number" name="numero_ore" class="input-field" required>
            </div>
        </div>
    </div>


    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Materia --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Modalità <span class="text-red-500">*</span></label>
            <select name="modalita" class="input-field">
                <option value="">Seleziona una modalità</option>
                <option value="Contanti">Contanti</option>
                <option value="Bonifico">Bonifico</option>
                <option value="PayPal">PayPal</option>
                <option value="Satispay">Satispay</option>
                <option value="Revolut">Revolut</option>
                {{-- aggiungi altre opzioni qui --}}
            </select>
        </div>
    </div>

    <!-- Terza riga -->
    <div>
        <label class="primary-text text-sm font-medium">Note</label>
        <textarea name="note" rows="4" class="input-field"></textarea>
    </div>

</form>

@endsection
