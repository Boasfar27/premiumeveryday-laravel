/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#B03052',
                    dark: '#3D0301',
                },
                secondary: '#D76C82',
                'secondary-light': '#E98E9F'
            },
            spacing: {
                '128': '32rem',
            },
            maxWidth: {
                '8xl': '88rem',
                '9xl': '96rem',
            },
            screens: {
                '3xl': '1792px',
            },
            zIndex: {
                '60': '60',
                '70': '70',
                '80': '80',
                '90': '90',
                '100': '100',
            },
            fontFamily: {
                sans: ['Figtree', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('flowbite/plugin'),
    ],
} 