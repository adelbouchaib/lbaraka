<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.css" rel="stylesheet" />
        @vite('resources/css/app.css')
        @livewireStyles
    </head>

    <body>
        @livewire('partials.navbar')
        <main>
            {{ $slot }}
        </main>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @livewireScripts
        @livewire('partials.footer')
    </body>
</html>