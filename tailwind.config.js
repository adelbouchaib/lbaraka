import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/jaocero/filachat/resources/views/**/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                arabic: ['Tajawal', 'Noto Sans Arabic', 'Arial', 'sans-serif'],
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
