import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import wayfinder from '@laravel/vite-plugin-wayfinder';
import path from 'path'; // <--- Agrega esto

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue(),
        tailwindcss(),
        wayfinder(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'), // <--- Esto es lo que activa el @
        },
    },
});