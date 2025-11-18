@extends('layouts.app')

@section('page-title', 'Pagamento di ' . $payment->student->nome . " " . $payment->student->cognome)

@section('action-buttons')
<div class="flex gap-2">

    {{-- Torna allo studente --}}
    <a href="{{ route('students.show', $payment->student) }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50">
        Indietro
    </a>

    {{-- Modifica --}}
    <a href="{{ route('payments.edit', $payment) }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Modifica
    </a>

</div>
@endsection


@section('content')

<div class="flex flex-col gap-6">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Data --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Data</label>
            <input type="date" value="{{ $payment->data }}" readonly
                   class="border border-gray-200 rounded-lg px-3 py-2 bg-gray-100">
        </div>

        <div class="flex flex-row gap-4">
            {{-- Importo --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-sm font-medium">Importo</label>
                <input type="number" value="{{ $payment->importo }}" readonly
                       class="border border-gray-200 rounded-lg px-3 py-2 bg-gray-100">
            </div>

            {{-- Numero ore --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-sm font-medium">Numero ore</label>
                <input type="number" value="{{ $payment->numero_ore }}" readonly
                       class="border border-gray-200 rounded-lg px-3 py-2 bg-gray-100">
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Modalità --}}
        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium">Modalità</label>
            <input type="text" value="{{ $payment->modalita }}" readonly
                   class="border border-gray-200 rounded-lg px-3 py-2 bg-gray-100">
        </div>
    </div>

    {{-- Note --}}
    <div>
        <label class="text-sm font-medium">Note</label>
        <textarea rows="4" readonly
                  class="border border-gray-200 rounded-lg px-3 py-2 w-full bg-gray-100">{{ $payment->note }}</textarea>
    </div>

</div>

@endsection
