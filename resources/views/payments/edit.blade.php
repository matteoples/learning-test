@extends('layouts.app')

@section('page-title', 'Modifica Pagamento per ' . $payment->student->getNomeCompleto())
@section('back-button-route', route('students.show', $payment->student))

@section('action-buttons')
<div class="flex gap-2">
    {{-- Bottone Salva --}}
    <button type="submit" form="create-payment-form" class="primary-button px-4 py-2">
        Salva Modifiche
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

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Data --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">
                Data <span class="text-red-500">*</span>
            </label>
            <input type="date" name="data" required value="{{ $payment->data }}" class="input-field">
        </div>

        <div class="flex flex-row gap-4">
            {{-- Importo --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">
                    Importo <span class="text-red-500">*</span>
                </label>
                <input type="number" name="importo" required value="{{ $payment->importo }}" class="input-field w-full">
            </div>

            {{-- Numero ore --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="primary-text text-sm font-medium">
                    Numero Ore <span class="text-red-500">*</span>
                </label>
                <input type="number" name="numero_ore" required value="{{ $payment->numero_ore }}" class="input-field w-full">
            </div>
        </div>
    </div>

    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Modalità --}}
        <div class="flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">
                Modalità <span class="text-red-500">*</span>
            </label>
            <select name="modalita" required class="input-field">
                <option value="">Seleziona una modalità</option>
                @foreach (['Contanti','Bonifico','PayPal','Satispay','Revolut'] as $mode)
                    <option value="{{ $mode }}" {{ $payment->modalita === $mode ? 'selected' : '' }}>
                        {{ $mode }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Terza riga -->
    <div class="flex flex-col gap-1">
        <label class="primary-text text-sm font-medium">Note</label>
        <textarea name="note" rows="4" class="input-field">{{ $payment->note }}</textarea>
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
