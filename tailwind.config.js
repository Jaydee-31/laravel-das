import defaultTheme from 'tailwindcss/defaultTheme';
import preset from './vendor/filament/support/tailwind.config.preset'
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    darkMode: 'class',
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
