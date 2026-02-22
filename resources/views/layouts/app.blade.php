<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', default: 'SMART TRIKE - Dashboard') }}</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

  
</head>

<body class="bg-white min-h-screen h-screen ">
    @yield('content')


    @yield('scripts')
</body>
<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.0/dist/flowbite.min.js"></script>

</html>