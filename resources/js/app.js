document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('button[data-mode]');

    // Imposta lo stato iniziale basandosi su localStorage o preferenza sistema
    let darkMode = localStorage.getItem('dark-mode');
    if (darkMode === null) {
        darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    } else {
        darkMode = darkMode === 'true';
    }

    const setDarkMode = (mode) => {
        const isDark = mode === 'dark';
        document.documentElement.classList.toggle('dark', isDark);
        localStorage.setItem('dark-mode', isDark);

        // Aggiorna lo style dei bottoni
        buttons.forEach(btn => {
            if (btn.dataset.mode === mode) {
                btn.classList.add('bg-even', 'primary-text', 'cursor-default');
                btn.classList.remove('cursor-pointer');
            } else {
                btn.classList.remove('bg-even', 'cursor-default');
                btn.classList.add('cursor-pointer');
            }
        });
    };

    // Applica lo stato iniziale
    setDarkMode(darkMode ? 'dark' : 'light');

    // Event listener su tutti i bottoni
    buttons.forEach(btn => {
        btn.addEventListener('click', () => setDarkMode(btn.dataset.mode));
    });

    // Se hai il toggle separato 🌙/☀️ puoi collegarlo qui:
    const toggle = document.getElementById('dark-mode-toggle');
    if (toggle) {
        toggle.addEventListener('click', () => {
            setDarkMode(document.documentElement.classList.contains('dark') ? 'light' : 'dark');
        });
    }
});
