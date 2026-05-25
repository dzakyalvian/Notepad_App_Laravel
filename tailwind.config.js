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
                brand: {
                    primary: '#ea580c',      // Accent orange
                    light: '#ffedd5',        // Soft brand background for active state
                    dark: '#c2410c',         // Darker brand text
                },
                keep: {
                    bg: '#f1f3f4',           // Soft grey background
                    navbar: '#ffffff',       // Pure white navbar
                    card: '#ffffff',         // Note cards
                    textPrimary: '#202124',  // Main headings
                    textSecondary: '#5f6368',// Subtext & sidebar buttons
                    textBody: '#3c4043',     // Comfortable note body text
                    border: '#dadce0',       // Clean Keep borders
                    borderHover: '#bdc1c6',  // Hover card borders
                },
                tag: {
                    personalBg: '#f3e8ff',
                    personalText: '#6b21a8',
                    workBg: '#d1fae5',
                    workText: '#065f46',
                    ideaBg: '#fef3c7',
                    ideaText: '#b45309',
                    importantBg: '#fee2e2',
                    importantText: '#991b1b',
                    studyBg: '#dbeafe',
                    studyText: '#1e40af',
                    defaultBg: '#f3f4f6',
                    defaultText: '#374151',
                }
            }
        },
    },

    plugins: [forms],
};
