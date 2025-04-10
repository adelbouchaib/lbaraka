<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- PWA  -->
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">



        <style>

        @import url('https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&family=Noto+Kufi+Arabic:wght@100..900&display=swap');
        </style>
        <style>
            .rtl {
  direction: rtl;
}
            </style>



<title>@yield('title', 'Default Title')</title>


        <!-- <title>{{ $title ?? 'Supplaio' }}</title> -->
        <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
        @vite('resources/css/app.css')
        @livewireStyles
    </head>

    <body>
        @livewire('partials.navbar')
        <!-- Button that triggers the install prompt -->
<button id="install-button" style="display: none;">Install App</button>

        <main>
            {{ $slot }}
        </main>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @livewireScripts
        @livewire('partials.footer')

<script>

     // Your service worker logic
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register("/sw.js").then(
      (registration) => {
        console.log("Service worker registration succeeded:", registration);
      },
      (error) => {
        console.error(`Service worker registration failed: ${error}`);
      }
    );
    }

    let deferredPrompt; // This will hold the prompt event

// Listen for the 'beforeinstallprompt' event
window.addEventListener('beforeinstallprompt', (event) => {
    // Prevent the default behavior of the prompt
    event.preventDefault();
    // Save the event for later use
    deferredPrompt = event;

    // Show the install button
    const installButton = document.getElementById('install-button');
    installButton.style.display = 'block'; // Make the button visible

    // When the install button is clicked, trigger the install prompt
    installButton.addEventListener('click', () => {
        deferredPrompt.prompt(); // Show the install prompt to the user

        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
            deferredPrompt = null; // Reset the prompt after the user responds
        });
    });
});

</script>

       


    </body>
</html>