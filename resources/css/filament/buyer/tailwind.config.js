import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Buyer/**/*.php',
        './resources/views/filament/buyer/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/jaocero/filachat/resources/views/**/**/*.blade.php',
    ],
}
