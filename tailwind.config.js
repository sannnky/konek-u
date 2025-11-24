import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary: '#343b85',   // Warna Ungu Gelap Header
                secondary: '#324cc7', // Warna Biru Tombol Utama
                dark: '#1f0d43',      // Warna Teks Gelap
            }
        },
    },

    plugins: [forms],
};
