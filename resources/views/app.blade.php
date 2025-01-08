<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Xtream Panel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:100,200,300,400,500,600,700,800,900" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    <!-- Xtream Config -->
    <script>
        window.xtreamConfig = {
            apiUrl: "{{ config('xtream.api_url') }}",
            username: "{{ config('xtream.username') }}",
            password: "{{ config('xtream.password') }}",
            epgUrl: "{{ config('xtream.epg_url') }}",
        };
    </script>

    @inertia
</body>
</html>