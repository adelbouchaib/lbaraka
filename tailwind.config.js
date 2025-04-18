import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'false',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/jaocero/filachat/resources/views/**/**/*.blade.php',
        './views/vendor/filachat/filachat/components/*.blade.php',
        './vendor/bezhansalleh/filament-language-switch/resources/views/language-switch.blade.php',
    ],
    theme: {
        extend: {
            colors: {
              primary: '#0071f5', // Primary color
              secondary: '#fbbc04'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                arabic: ['Alexandria', 'Noto Sans Arabic', 'Arial', 'sans-serif'],
            },
            typography: {
                DEFAULT: {
                  css: {
                    p: {
                      marginTop: '0rem',  // Adjust as needed
                      marginBottom: '0rem',
                    },
                    figure: {
                        marginTop: '1rem',  // Adjust as needed
                        marginBottom: '1rem',
                    },
                    img: {
                        marginTop: '1rem',  // Adjust as needed
                        marginBottom: '1em',
                    },
                  },
                },
            },
        },
    },
  plugins: [require('@tailwindcss/typography')],
};
