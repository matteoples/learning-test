import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),   // <--- DEVE essere attivo
        
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            origin: 'https://learning-test.onrender.com',
        }),
    ],
});