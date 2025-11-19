import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => ({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    base: mode === 'production' ? '/' : '', // optional
    server: {
        https: true,          // solo per dev locale se vuoi usare https
        host: true,
    }
}));
