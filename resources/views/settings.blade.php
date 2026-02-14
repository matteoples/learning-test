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
@endsection


@section('content')
<main class="flex flex-col gap-6">

    <div class="section p-6 flex flex-col gap-4 h-full">
        <div class="flex justify-between items-center mb-4">
            <h2 class="primary-text text-xl font-semibold">Materie che insegni</h2>

            <div class="flex gap-2">
                <button id="edit-btn" type="button" class="primary-button px-4 py-2">Modifica</button>
                
                <button id="save-btn" type="submit" form="subjects-form"
                    class="primary-button px-4 py-2 hidden">Salva</button>

                <button id="cancel-btn" type="button" class="secondary-button px-4 py-2 hidden">Annulla</button>
            </div>
        </div>


        <form id="subjects-form" action="{{ route('settings.update-subjects') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                @foreach($allSubjects as $subject)
                    <div class="card p-3 h-full flex flex-col justify-between">
                        
                        <label class="inline-flex items-center gap-2 p-2 hover:bg-odd cursor-pointer">
                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                class="form-checkbox subject-checkbox"
                                {{ in_array($subject->id, $userSubjects) ? 'checked' : '' }}
                                disabled>
                            <div class="pr-5 flex-1">
                                <p class="primary-text font-medium">{{ $subject->nome }}</p>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
        </form>


    </div>
</main>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('edit-btn');
    const saveBtn = document.getElementById('save-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const checkboxes = document.querySelectorAll('.subject-checkbox');

    // Modalità Read
    function setReadMode() {
        checkboxes.forEach(cb => cb.disabled = true);
        editBtn.classList.remove('hidden');
        saveBtn.classList.add('hidden');
        cancelBtn.classList.add('hidden');
    }

    // Modalità Edit
    function setEditMode() {
        checkboxes.forEach(cb => cb.disabled = false);
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
</script>

@endsection
