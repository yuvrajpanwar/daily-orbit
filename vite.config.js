import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // single entry — imports CSS from JS
            refresh: true,
        }),
    ],
    assetsInclude: ['**/*.ttf', '**/*.woff', '**/*.woff2', '**/*.eot'],
});
