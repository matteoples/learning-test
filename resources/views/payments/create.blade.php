@extends('layouts.app')

@section('page-title', 'Nuovo Pagamento per ' . $student->nome . ' ' . $student->cognome)

@section('action-buttons')
<div class="flex gap-2">

    {{-- Bottone Annulla --}}
    <a href="{{ route('students.show', $student) }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        Annulla
    </a>

    {{-- Bottone Salva --}}
    <button type="submit" form="create-payment-form"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Salva
    </button>

</div>
@endsection


@section('content')

<form id="create-payment-form" action="{{ route('payments.store', $student) }}" method="POST" class="flex flex-col gap-6">
    @csrf

    <!-- Prima riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Giorno --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">
                Data <span class="text-red-500">*</span>
            </label>
            <input type="date" name="data" required
                   class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
        </div>

        <div class="flex flex-row gap-4">
            {{-- Importo --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-sm font-medium">
                    Importo <span class="text-red-500">*</span>
                </label>
                <input type="number" name="importo" required
                    class="border border-gray-200 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">
            </div>

            {{-- Numero  ore --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-sm font-medium">
                    Numero Ore <span class="text-red-500">*</span>
                </label>
                <input type="number" name="numero_ore" required
                    class="border border-gray-200 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">
            </div>
        </div>

        

    </div>


    <!-- Seconda riga -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Materia --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Modalità <span class="text-red-500">*</span></label>
            <select name="modalita"
                    class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none required">
                <option value="">Seleziona una modalità</option>
                <option value="Contanti">Contanti</option>
                <option value="Bonifico">Bonifico</option>
                <option value="PayPal">PayPal</option>
                <option value="Satispay">Satispay</option>
                <option value="Revolut">Revolut</option>
                {{-- aggiungi altre materie qui --}}
            </select>
        </div>
    </div>

    <!-- Terza riga -->
    <div>
        <label class="text-sm font-medium">Note</label>
        <textarea name="note" rows="4"
                  class="border border-gray-200 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-200 focus:outline-none"></textarea>
    </div>

</form>

@endsection
