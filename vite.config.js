import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import 'flowbite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/components/file-max-size.js',
                'resources/js/components/image-preview-article.js',
                'resources/js/components/image-preview-news.js',
                'resources/js/components/image-preview-users.js',
                'resources/js/components/select-all-rows-table.js',
                'resources/js/components/textarea-quill.js',
            ],
            refresh: true,
        }),
    ],
});
