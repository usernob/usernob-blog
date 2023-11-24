<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title ?? '' }} | {{ config('app.name', 'usernob_blog') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        if (localStorage.getItem('darkmode') === 'true') {
            document.documentElement.classList.add("dark")
        } else {
            document.documentElement.classList.remove("dark")
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? '' }}
    @livewireStyles
</head>

<body class="font-sans bg-background text-foreground transition-all duration-200 ease-in-out scroll-smooth antialiased">
    <noscript class="w-full h-full flex items-center justify-center fixed top-0 bg-white/40 z-[999] backdrop-blur-md">
        <h1 class="text-center">Yo Bro It's 2023, And You Still Didn't Enable JavaScript?</h1>
    </noscript>
    {{ $slot }}
    @livewireScriptConfig
</body>

</html>
