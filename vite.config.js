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
                'resources/css/admin-article.css',
                'resources/css/admin-article-create.css',
                'resources/css/settings.css',
                'resources/css/experience.css',
                'resources/css/admin-experience.css',
                'resources/css/admin-add-additional.css',
                'resources/js/admin/add-additional.js',
                'resources/js/app.js',
                'resources/css/admin/settings/general-settings/hostel-information.css',
                'resources/js/admin/settings/general-settings/hostel-information.js',
                'resources/css/admin/settings/general-settings/operational-policies.css',
                'resources/js/admin/settings/general-settings/operational-policies.js',
            ],
            refresh: true,
        }),
    ],
});
