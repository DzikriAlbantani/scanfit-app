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
                'brand-dark': '#2F4156',
                'brand-secondary': '#567C8D',
                'brand-beige': '#F5F5DC',
                'brand-bg': '#C8D9E6',
            },
            backgroundImage: {
                'brand-haze': "linear-gradient(135deg, rgba(200,217,230,0.25) 0%, rgba(255,255,255,0.85) 40%, #f8fafc 100%)",
            },
        },
    },

    plugins: [forms],
};
