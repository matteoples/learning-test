@extends('layouts.app')

@section('page-title', 'Modifica Pagamento per ' . $payment->student->getNomeCompleto())
@section('back-button-route', route('students.show', $payment->student))

@section('action-buttons')
<div class="flex gap-2">
    {{-- Bottone Salva --}}
    <button type="submit" form="create-payment-form"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Salva
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

        {{-- Giorno --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">
                Data <span class="text-red-500">*</span>
            </label>
            <input type="date" name="data" required
                   value="{{ $payment->data }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        <div class="flex flex-row gap-4">
            {{-- Importo --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-sm font-medium">
                    Importo <span class="text-red-500">*</span>
                </label>
                <input type="number" name="importo" required
                       value="{{ $payment->importo }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">
            </div>

            {{-- Numero ore --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-sm font-medium">
                    Numero Ore <span class="text-red-500">*</span>
                </label>
                <input type="number" name="numero_ore" required
                       value="{{ $payment->numero_ore }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">
            </div>
        </div>

    </div>

    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Modalità --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Modalità <span class="text-red-500">*</span></label>
            <select name="modalita" required
                    class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">

                <option value="">Seleziona una modalità</option>

                @foreach (['Contanti','Bonifico','PayPal','Satispay','Revolut'] as $mode)
                    <option value="{{ $mode }}"
                        {{ $payment->modalita === $mode ? 'selected' : '' }}>
                        {{ $mode }}
                    </option>
                @endforeach

            </select>
        </div>
    </div>

    <!-- Terza riga -->
    <div>
        <label class="text-sm font-medium">Note</label>
        <textarea name="note" rows="4"
                  class="border border-gray-200 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">{{ $payment->note }}</textarea>
    </div>

</form>

<div class="mt-6">
    <div class="border-t border-gray-200 mb-6"></div>

    <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo pagamento?');">
        @csrf
        @method('DELETE')
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            Elimina pagamento
        </button>
        </div>
    </form>
</div>

@endsection

