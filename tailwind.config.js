const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/**/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        {
            pattern: /(bg|text)-(.*)-(\d{1}0{1,2})/,
            variants: ['active', 'hover', 'focus']
        }
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
