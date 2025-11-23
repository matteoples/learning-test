@extends('layouts.app')

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

    <!-- Grid 3x1 -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="section p-4">
            <p class="primary-text font-bold text-lg">Titolo Card 1</p>
            <p class="secondary-text text-sm mt-1">Sottotitolo Card 1</p>
        </div>

        <div class="section p-4">
            <p class="primary-text font-bold text-lg">Titolo Card 2</p>
            <p class="secondary-text text-sm mt-1">Sottotitolo Card 2</p>
        </div>

        <div class="section p-4">
            <p class="primary-text font-bold text-lg">Titolo Card 3</p>
            <p class="secondary-text text-sm mt-1">Sottotitolo Card 3</p>
        </div>
    </div>

    <!-- Due colonne 50% ciascuna -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-[400px]">
        <div class="section flex flex-col">
            <p class="primary-text font-bold text-lg">Prossimi Appuntamenti</p>
            <p class="secondary-text text-sm mt-1">Testo secondario 1</p>
        </div>

        <div class="flex flex-col gap-4">
            <div class="section flex flex-col">
                <p class="primary-text font-bold text-lg">Debiti</p>
                <p class="secondary-text text-sm mt-1">Testo secondario 2</p>
            </div>

            <div class="section flex flex-col">
                <p class="primary-text font-bold text-lg">Crediti</p>
                <p class="secondary-text text-sm mt-1">Testo secondario 2</p>
            </div>  
        </div>
    </div>

</main>
@endsection
