@extends('layouts.app')

@section('page-title', 'Dettagli Studente')

@section('action-buttons')
<div class="flex gap-2">
    {{-- Torna alla lista --}}
    <a href="{{ route('students.index') }}"
       class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        Indietro
    </a>

    {{-- Modifica --}}
    <a href="{{ route('students.edit', $student) }}"
{{--        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
 --}}        class="px-4 py-2 bg-blue-600 text-white rounded-lg opacity-50 pointer-events-none">
        Esporta Dati
    </a>
</div>
@endsection

@section('content')

<div class="flex gap-4">

    
    <div class="flex flex-col gap-4 w-[35%]">
        <div class="bg-white border border-gray-200 rounded-[12px] p-6 flex flex-col gap-4">

            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Anagrafica</h2>
                <a href="{{ route('students.edit', $student) }}"
            class="px-4 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Modifica
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                {{-- Nome --}}
                <div>
                    <p class="text-gray-500 text-sm">Nome</p>
                    <p class="font-medium">{{ $student->nome }}</p>
                </div>

                {{-- Cognome --}}
                <div>
                    <p class="text-gray-500 text-sm">Cognome</p>
                    <p class="font-medium">{{ $student->cognome }}</p>
                </div>

                {{-- Data di nascita --}}
                <div>
                    <p class="text-gray-500 text-sm">Data di nascita</p>
                    <p class="font-medium">{{ $student->data_nascita ? $student->data_nascita->format('d/m/Y') : '-' }}</p>
                </div>

                {{-- Telefono --}}
                <div>
                    <p class="text-gray-500 text-sm">Telefono</p>
                    <p class="font-medium">{{ $student->telefono ?? '-' }}</p>
                </div>

                {{-- Email --}}
                <div>
                    <p class="text-gray-500 text-sm">Email</p>
                    <p class="font-medium">{{ $student->email ?? '-' }}</p>
                </div>

                {{-- Indirizzo --}}
                <div>
                    <p class="text-gray-500 text-sm">Indirizzo</p>
                    <p class="font-medium">{{ $student->indirizzo ?? '-' }}</p>
                </div>

                {{-- Scuola --}}
                <div>
                    <p class="text-gray-500 text-sm">Scuola</p>
                    <p class="font-medium">{{ $student->scuola ?? '-' }}</p>
                </div>

                {{-- Classe --}}
                <div>
                    <p class="text-gray-500 text-sm">Classe</p>
                    <p class="font-medium">{{ $student->classe ?? '-' }}</p>
                </div>

                {{-- Note (a tutta larghezza) --}}
                <div class="md:col-span-2">
                    <p class="text-gray-500 text-sm">Note</p>
                    <p class="font-medium">{{ $student->note ?? '-' }}</p>
                </div>

            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-[12px] p-6 flex flex-col gap-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Pagamenti</h2>
                <a href="{{ route('students.edit', $student) }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    +
                </a>
            </div>
            
            <div class="grid grid-cols-1 gap-3">
                @for ($i = 0; $i < 5; $i++)
                    @php
                        // Genera una data random tra oggi e 30 giorni fa
                        $randomDate = \Carbon\Carbon::today()->subDays(rand(0, 30))->format('d/m/Y');
                        // Genera un importo random tra 50 e 500
                        $randomAmount = rand(50, 500);
                    @endphp

                    <div>
                        <p class="text-gray-500 text-xs">{{ $randomDate }}</p>
                        <p class="font-medium">${{ $randomAmount }}</p>
                    </div>

                    @if ($i < 4)
                        <div class="border-t border-gray-100"></div>
                    @endif
                @endfor
            </div>


        </div>
    </div>

    <div class="flex flex-col w-full">
        <div class="bg-white border border-gray-200 rounded-[12px] p-6 flex flex-col gap-4 h-full">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Lezioni</h2>
                <a href="{{ route('students.edit', $student) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Nuova Lezione
                </a>
            </div>


            <div class="grid grid-cols-3 gap-3">
                @for ($i = 0; $i < 5; $i++)
                    @php
                        $randomDate = \Carbon\Carbon::today()->subDays(rand(0, 30))->format('d/m/Y');
                    @endphp


                    <div class="bg-[#FDFDFC] dark:bg-[#161615] border border-gray-200 rounded-[12px] p-5 flex flex-col gap-2 h-full">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-xs">{{ $randomDate }}</p>
                                <p class="font-medium">Informatica</p>
                            </div>
                            <div>
                                <p class="font-large"> 1:30h</p>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs">lorem ipsum </p>
                    </div>
                @endfor
            </div>
        </div>
    </div>


</div>







@endsection
