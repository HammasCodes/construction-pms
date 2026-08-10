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
                // Electric lime accent (#aeff00) — the single brand colour.
                brand: {
                    50: '#f6ffe0',
                    100: '#ecffb3',
                    200: '#ddff80',
                    300: '#ccff4d',
                    400: '#bdff26',
                    500: '#aeff00',
                    600: '#93d900',
                    700: '#74ab00',
                    800: '#567e00',
                    900: '#3f5c00',
                    950: '#1f2e00',
                },
                acid: '#aeff00',
                ink: {
                    950: '#000000',
                    900: '#0a0a0a',
                    800: '#141414',
                    700: '#1f1f1f',
                    600: '#2b2b2b',
                },
            },
            boxShadow: {
                soft: '0 1px 2px 0 rgba(0, 0, 0, 0.04), 0 1px 3px 0 rgba(0, 0, 0, 0.06)',
                card: '0 4px 20px -6px rgba(0, 0, 0, 0.10), 0 2px 6px -2px rgba(0, 0, 0, 0.06)',
                lift: '0 20px 44px -14px rgba(0, 0, 0, 0.22), 0 8px 16px -8px rgba(0, 0, 0, 0.12)',
                glow: '0 0 0 1px rgba(174, 255, 0, 0.30), 0 10px 30px -6px rgba(174, 255, 0, 0.45)',
            },
            backgroundImage: {
                'grid-lime': 'linear-gradient(to right, rgba(174,255,0,0.12) 1px, transparent 1px), linear-gradient(to bottom, rgba(174,255,0,0.12) 1px, transparent 1px)',
            },
            keyframes: {
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(12px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'scale-in': {
                    '0%': { opacity: '0', transform: 'scale(0.96)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                'slide-in-left': {
                    '0%': { opacity: '0', transform: 'translateX(-14px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-6px)' },
                },
                shimmer: {
                    '100%': { transform: 'translateX(100%)' },
                },
                'pulse-soft': {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.55' },
                },
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.5s cubic-bezier(0.22, 1, 0.36, 1) both',
                'fade-in': 'fade-in 0.4s ease-out both',
                'scale-in': 'scale-in 0.35s cubic-bezier(0.22, 1, 0.36, 1) both',
                'slide-in-left': 'slide-in-left 0.4s cubic-bezier(0.22, 1, 0.36, 1) both',
                float: 'float 5s ease-in-out infinite',
                shimmer: 'shimmer 1.6s infinite',
                'pulse-soft': 'pulse-soft 2s ease-in-out infinite',
            },
        },
    },

    plugins: [forms],
};
