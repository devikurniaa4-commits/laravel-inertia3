// Mengimpor tema default Tailwind dan plugin formulir.
import defaultTheme from 'tailwindcss/defaultTheme';
// Mengimpor plugin Tailwind untuk menata elemen formulir.
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
// Mengatur lokasi template yang dipindai Tailwind untuk membuat kelas CSS.
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    // Menyesuaikan tema bawaan aplikasi.
    theme: {
        extend: {
            // Menetapkan Figtree sebagai font sans utama.
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    // Mengaktifkan plugin formulir Tailwind.
    plugins: [forms],
};
