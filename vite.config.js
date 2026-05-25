import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/dashboard.css',
                'resources/css/guest-details.css',
                'resources/css/manage-revenue.css',
                'resources/css/modal-revenue.css',
                'resources/css/finance-accounting.css',
                'resources/css/roombed.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
