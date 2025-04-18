<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-11R0RELLYH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-11R0RELLYH');
</script>

<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "r4zku2rguc");
</script>


        <style>

        @import url('https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&family=Noto+Kufi+Arabic:wght@100..900&display=swap');
        </style>
        <style>
             .rtl {
  direction: rtl;
}
.ltr {
  direction: ltr;
}
            </style>



<title>@yield('title', 'Default Title')</title>


        <!-- <title>{{ $title ?? 'Supplaio' }}</title> -->
        <link rel="icon" type="image/png" href="{{ asset('images/ICON.png') }}">
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


    </body>
</html>