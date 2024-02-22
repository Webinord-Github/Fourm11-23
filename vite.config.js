import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/forum.css',
                'resources/css/tools.css',
                'resources/css/lexique.css',
                'resources/css/main.css',
                'resources/css/chatbot.css',
                'resources/css/register.css',
                'resources/css/login.css',
                'resources/css/forgotpassword.css',
                'resources/css/header.css',
                'resources/css/member-card.css',
                'resources/css/invalid-reset-password.css',
                'resources/css/calendar.css',
                'resources/css/home.css',
                'resources/css/fourmiliere.css',
                'resources/css/events.css',
                'resources/css/members.css',
                'resources/css/sortablemenu.css',
                'resources/css/automatic-emails.css',
                'resources/css/admin.css',
                'resources/css/dashboard.css',
                'resources/css/intimidation.css',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
