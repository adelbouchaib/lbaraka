import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Buyer/**/*.php',
        './resources/views/filament/buyer/**/*.blade.php',
        './resources/views/components/topbar-component.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/jaocero/filachat/resources/views/**/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primaryx: '#0071f5', // Custom primary color
                secondaryx: '#fbbc04', // Custom primary color
            },
            fontFamily: {
                arabic: ['Alexandria', 'Noto Sans Arabic', 'Arial', 'sans-serif'],
            },
        },
    },
   
}
