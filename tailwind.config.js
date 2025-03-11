import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    darkMode: ['class', '[data-theme="dark"]'],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'system-ui'],
            },
            boxShadow: {
                card: '0px 0px 20px 0px rgba(0, 0, 0, 0.15)',
            },
            transitionDuration: {
                DEFAULT: '300ms',
            },
            minHeight: {
                24: '96px',
            },
            colors: {
                cyan: {
                    500: '#46b6bf',
                    700: '#0f929a',
                    200: '#bceff3',
                },
                red: {
                    500: '#ee4322',
                },
                black: '#1d1e1c',
                white: '#ffffff',
                transparent: 'transparent',
            },
        },
        container: {
            padding: '2rem',
            center: true,
            screens: {
                '2xl': '1400px',
            },
        },
    },
    daisyui: {
        themes: ['fantasy', 'dark'],
    },

    plugins: [forms, typography, require('daisyui')],
};
