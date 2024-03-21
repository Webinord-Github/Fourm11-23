import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin.css',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/automatic-emails.css',
                'resources/css/blogue.css',
                'resources/css/calendar.css',
                'resources/css/chatbot.css',
                'resources/css/chatuser.css',
                'resources/css/dashboard.css',
                'resources/css/events.css',
                'resources/css/facts.css',
                'resources/css/forgotpassword.css',
                'resources/css/forum.css',
                'resources/css/fourmiliere.css',
                'resources/css/header.css',
                'resources/css/home.css',
                'resources/css/intimidation.css',
                'resources/css/invalid-reset-password.css',
                'resources/css/lexique.css',
                'resources/css/login.css',
                'resources/css/main.css',
                'resources/css/maintenance.css',
                'resources/css/member-card.css',
                'resources/css/members.css',
                'resources/css/membre.css',
                'resources/css/profil.css',
                'resources/css/register.css',
                'resources/css/singleblog.css',
                'resources/css/sortablemenu.css',
                'resources/css/source.css',
                'resources/css/tools.css',
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
