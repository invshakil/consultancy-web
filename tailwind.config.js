const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    important: true,
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            'white': '#ffffff',
            'whiteDark': '#D9D9D9',
            'offWhite': '#f5f5f5',
            'yellowLight': '#FFF4C7',
            'mainBlue': '#3c2060',
            'lightBlue': '#4a4b62',
            'disableBlue': '#7d83b2',
            'midnight': '#121063',
            'text': '#282828',
            'text2': '#b21919',
            'metal': '#8f8eb7',
            'tahiti': '#45836b',
            'lightGreen': '#2da676',
            'complete': '#E2EFDA',
            'pending': '#FEDC81',
            'cancel': '#2da676',
            'cancelBackup': '#de5a06',
            'silver': '#ecebff',
            'grey': '#838282',
            'lightgrey': '#b2b2b2',
            'errorBg': '#ffeeee',
            'red': '#b21919',
            'green': '#20A100',
            'bubble-gum': '#e854d0',
            'bermuda': '#78dcca',
            'setMIX': '#4d9182',
        },
        extend: {

            // that is animation class
            animation: {
                fade: 'fadeOut 5s ease-in-out',
            },

            // that is actual animation
            keyframes: theme => ({
                fadeOut: {
                    '0%': { backgroundColor: theme('colors.red.300') },
                    '100%': { backgroundColor: theme('colors.transparent') },
                },
            }),
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
};
