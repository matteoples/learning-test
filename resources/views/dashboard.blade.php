@php
use App\Enums\FontWeight as FW;
@endphp


@extends('layouts.app')


{{--/**************************************************************************************

La dashboard ha due sezioni. La prima, "Prossimi Appuntamenti", deve mostrare i prossimi 5 
appuntamenti che lo user ha. Di ogni lezione ci interessa il nome / cognome dello studente, 
la durata, il luogo e le note. 

Nella seconda sezione invece, sono salvati i debiti e i crediti.
Nel box dei debiti, vengono mostrati tutti i debiti, ordinati in ordine decrescente con 
"Nome Cognome: Importo". Cliccando su un debito, si viene rimandati alla pagina per aggiungere 
un pagamento per il dato giorno specifico e nel campo data viene inserito il giorno attuale. 
Nel box dei crediti, vengono mostrati i crediti > 0, ordinati in ordine decrescente con 
"Nome Cognome: Importo". Cliccando su un credito, si viene rimandati alla pagina per inserire 
una nuova lezione per il dato studente. 

**************************************************************************************/--}}



@section('page-title', 'Dashboard')

@section('action-buttons')
<div class="flex gap-2">
    @php
        // Legge lo stato dark mode da localStorage o fallback a preferenza browser
        $darkMode = false; // valore iniziale lato Blade, lato JS aggiorneremo subito
    @endphp

    <div class="inline-flex bg-odd rounded-lg p-1 box-borders">
        @foreach (['light' => '🌞 Light', 'dark' => '🌙 Dark'] as $modeValue => $modeLabel)
            <button
                type="button"
                onclick="setDarkMode('{{ $modeValue }}')"
                data-mode="{{ $modeValue }}"
                class="primary-text px-4 py-2 rounded-md text-sm font-medium transition cursor-pointer">
                {{ $modeLabel }}
            </button>
        @endforeach
    </div>
</div>

<script>
    // Inizializza lo stato dark mode in base a localStorage o preferenza browser
    let darkMode = localStorage.getItem('dark-mode');
    if (darkMode === null) {
        darkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    } else {
        darkMode = darkMode === 'true';
    }
    document.documentElement.classList.toggle('dark', darkMode);

    function setDarkMode(mode) {
        const isDark = mode === 'dark';
        document.documentElement.classList.toggle('dark', isDark);
        localStorage.setItem('dark-mode', isDark);
        
        // Aggiorna classi pulsanti
        document.querySelectorAll('#action-buttons button').forEach(btn => {
            const btnMode = btn.textContent.includes('Dark') ? 'dark' : 'light';
            if (btnMode === mode) {
                btn.classList.remove('hover:bg-odd', 'cursor-pointer');
                btn.classList.add('bg-even', 'primary-text', 'cursor-default');
            } else {
                btn.classList.add('hover:bg-odd', 'cursor-pointer');
                btn.classList.remove('bg-even', 'cursor-default');
            }
        });
    }
</script>
@endsection

@section('content')
<main class="flex flex-col gap-6">
    
    <!-- Due colonne 50% ciascuna -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
       <div class="section flex flex-col">

            <x-title> Prossimi Appuntamenti</x-title>

            <div class="mt-2 flex flex-col gap-2">
                @forelse($nextLessons as $lesson)
                        <div class="card p-3 h-full">
                            <div class="flex justify-between items-center mb-1">
                                <p class="secondary-text text-xs">{{ $lesson->getTextGiornoFormatted() }}    -    {{ $lesson->getOraInizioFormatted() }} : {{ $lesson->getOraFineFormatted() }}</p>
                                <p class="primary-text font-large"> {{ $lesson->durata() }} h</p>
                            </div>
                            <div class="pr-5 flex-1">
                                <p class="primary-text text-lg font-medium">{{ $lesson->student->getNomeCognome() }}</p>
                                <p class="primary-text text-sm "> {{ $lesson->descrizione() }} </p>

                                
                                
                            </div>
                        </div>

                @empty
                    <p class="text-sm text-gray-400 mt-2">Nessun prossimo appuntamento.</p>
                @endforelse
            </div>
        </div>

        <div class="flex flex-col gap-4">
            {{-- Debiti --}}
            <div class="section flex flex-col">

                <x-title> Debiti </x-title>

                <div class="flex flex-col gap-2">
                    @forelse($debts as $student)
                        <a href="{{ route('payments.create', ['student' => $student->id]) }}">
                            <div class="card p-3 h-full">
                                <div class="flex justify-between items-center">
                                    <p class="primary-text text-sm">{{ $student->getNomeCognome() }}</p>
                                    <p class="font-semibold text-red-600"> € {{ abs($student->saldo()) }} </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-gray-400 mt-2">Nessun debito.</p>
                    @endforelse
                </div>
            </div>

            {{-- Crediti --}}
            <div class="section flex flex-col">

                <x-title> Crediti </x-title>

                <div class="flex flex-col gap-2">
                    @forelse($credits as $student)
                        <a href="{{ route('lessons.create', ['student' => $student->id]) }}">
                            <div class="card p-3 h-full">
                                <div class="flex justify-between items-center">
                                    <p class="primary-text text-sm">{{ $student->getNomeCognome() }}</p>
                                    <p class="font-semibold text-green-600"> € {{ abs($student->saldo()) }} </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-gray-400 mt-2">Nessun credito.</p>
                    @endforelse
                </div>
            </div>  

        </div>


    </div>

</main>
@endsection
