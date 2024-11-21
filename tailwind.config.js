/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: ["./src/**/*.{html,js}"],
    theme: {
        extend: {
            colors: {
                primary: '#000000',  // Negro
                secondary: '#52057B', // Morado oscuro
                lightGray: '#892CDC', // Morado claro
                darkGray: '#BC6FF1',  // Morado muy claro
                success: '#00A676',   // Verde suave
                error: '#D9534F',     // Rojo suave
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
