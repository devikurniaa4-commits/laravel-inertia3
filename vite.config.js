// Mengatur plugin dan konfigurasi Vite untuk membangun aset aplikasi.
// Mengimpor pembangun konfigurasi, plugin Laravel, dan plugin Vue.
import { defineConfig } from 'vite';
// Mengimpor plugin yang menghubungkan proses build Vite dengan Laravel.
import laravel from 'laravel-vite-plugin';
// Mengimpor plugin untuk memproses komponen Vue.
import vue from '@vitejs/plugin-vue';

// Mendaftarkan plugin yang diperlukan untuk memproses aset proyek.
export default defineConfig({
    plugins: [
        // Menentukan entry point JavaScript dan mengaktifkan refresh otomatis.
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        // Mengatur transformasi URL aset pada template Vue.
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
