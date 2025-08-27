import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            buildDirectory: 'public/build', // <- folder build di root
        }),
        tailwindcss(),
    ],
    build: {
        outDir: 'public/build', // <- folder build akan dibuat di root
        emptyOutDir: true,
    },
});
