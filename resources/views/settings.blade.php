@extends('layouts.app')

@section('page-title', 'Impostazioni')

@section('action-buttons')
<div class="flex gap-2" id="action-buttons">
    @php
        $darkMode = false; // fallback
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


<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('edit-btn');
    const saveBtn = document.getElementById('save-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const checkboxes = document.querySelectorAll('.subject-checkbox');

    // Modalità Read
    function setReadMode() {
        checkboxes.forEach(cb => {
            cb.disabled = true;
            cb.closest('.card').classList.remove('editable'); // rimuove il cursore pointer
        });
        editBtn.classList.remove('hidden');
        saveBtn.classList.add('hidden');
        cancelBtn.classList.add('hidden');
    }

    // Modalità Edit
    function setEditMode() {
        checkboxes.forEach(cb => {
            cb.disabled = false;
            cb.closest('.card').classList.add('editable'); // aggiunge il cursore pointer
        });
        editBtn.classList.add('hidden');
        saveBtn.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
    }

    // Inizializza in Read mode
    setReadMode();

    editBtn.addEventListener('click', setEditMode);

    cancelBtn.addEventListener('click', () => {
        // reset checkbox ai valori iniziali
        @foreach($allSubjects as $subject)
            document.querySelector('.subject-checkbox[value="{{ $subject->id }}"]').checked = {{ in_array($subject->id, $userSubjects) ? 'true' : 'false' }};
        @endforeach

        setReadMode();
    });

});

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.subject-checkbox');

    checkboxes.forEach(cb => {
        const card = cb.closest('.card');
        const checkmark = cb.closest('label').querySelector('.checkmark');

        function updateCheckmark() {
            if (cb.checked) {
                card.classList.add('card-selected');  // mantiene il colore di background
                checkmark.style.display = 'block';    // mostra checkmark
            } else {
                card.classList.remove('card-selected');
                checkmark.style.display = 'none';    // mostra checkmark
            }
        }

        updateCheckmark(); // stato iniziale
        cb.addEventListener('change', updateCheckmark); // aggiorna al click
    });
});


</script>

@endsection


@section('content')
<main class="flex flex-col gap-6">

    <div class="section p-6 flex flex-col gap-4 h-full">
        <div class="flex justify-between items-center mb-4">
            <h2 class="primary-text text-xl font-semibold">Materie che insegni</h2>

            <div class="flex gap-2">
                <button id="edit-btn" type="button" class="primary-button px-4 py-2">Modifica</button>
                
                <button id="cancel-btn" type="button" class="secondary-button px-4 py-2 hidden">Annulla</button>

                <button id="save-btn" type="submit" form="subjects-form"
                    class="primary-button px-4 py-2 hidden">Salva</button>

            </div>
        </div>


        <form id="subjects-form" action="{{ route('settings.update-subjects') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($allSubjects as $subject)
                    <div class="card p-3 h-full flex flex-col justify-between">
                        <label class="inline-flex items-center gap-2 p-2 hover:bg-odd cursor-pointer">
                            <input type="checkbox"
                                name="subjects[]"
                                value="{{ $subject->id }}"
                                class="form-checkbox subject-checkbox hidden"
                                {{ in_array($subject->id, $userSubjects) ? 'checked' : '' }}
                                disabled>
                            <div class="pr-5 flex-1">
                                <p class="primary-text font-medium">{{ $subject->nome }}</p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                            stroke="var(--accent-color)" class="size-6 checkmark" 
                            style="display: {{ in_array($subject->id, $userSubjects) ? 'block' : 'none' }};">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </label>
                    </div>
                @endforeach
            </div>

        </form>


    </div>



   <div class="section p-6 flex flex-col gap-4 h-full">
        <div class="flex justify-between items-center mb-4">
            <h2 class="primary-text text-xl font-semibold">Google Calendar</h2>
        </div>

        {{-- Sincronizza --}}
        <div class="flex flex-col md:flex-row items-start justify-between w-full  mx-auto py-4 border-b border-gray-200">
            <div class="flex flex-col w-full md:w-[400px] mb-4 md:mb-0">
                <p class="primary-text font-medium">Sincronizza Google Calendar</p>
                <p class="secondary-text text-sm">
                    Aggiunge al Google Calendar tutte le lezioni presenti solamente nel calendario interno dell'app.
                </p>
            </div>

            <form action="{{ route('google.sync') }}" method="POST" class="w-full md:w-auto">
                @csrf
                <button type="submit"
                    class="primary-button px-3 py-3 sm:px-4 w-full md:w-auto">
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Sincronizza
                    </div>
                </button>
            </form>
        </div>

        {{-- Resetta / Inizializza --}}
        <div class="flex flex-col md:flex-row items-start justify-between w-full mx-auto py-4">
            <div class="flex flex-col w-full md:w-[400px] mb-4 md:mb-0">
                <p class="primary-text font-medium">Inizializza Google Calendar</p>
                <p class="secondary-text text-sm">
                    Rimuove tutte le ripetizioni dal Google Calendar, preservandole nel calendario interno dell'app.
                </p>
            </div>

            <form action="{{ route('google.reset') }}" method="POST" class="w-full md:w-auto">
                @csrf
                <button type="submit"
                    class="destructive-button px-3 py-3 sm:px-4 w-full md:w-auto">
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        Inizializza
                    </div>
                </button>
            </form>
        </div>
    </div>



</main>





@endsection
