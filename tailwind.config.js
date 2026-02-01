/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    safelist: [
            'theme-cocina',
            'theme-mccafe',
            'theme-isla',
            'theme-servicio',
            'border-red-600',
            'border-yellow-500',
            'border-green-500',
            'bg-red-100',
            'bg-yellow-100',
            'bg-green-100',
            'text-red-600',
            'text-yellow-700',
            'text-green-700',
            'text-slate-700',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                puesto: {
                    app: 'var(--puesto-app-bg)',
                    header: 'var(--puesto-header-bg)',
                    'header-text': 'var(--puesto-header-text)',
                    btn: 'var(--puesto-btn-bg)',
                    'btn-text': 'var(--puesto-btn-text)',
                    'btn-border': 'var(--puesto-btn-border)',
                    'btn-hover-bg': 'var(--puesto-btn-hover-bg)',
                    'btn-hover-text': 'var(--puesto-btn-hover-text)',
                    accent: 'var(--puesto-accent-color)',
                }
            }
        }
    },
    plugins: [],
}

