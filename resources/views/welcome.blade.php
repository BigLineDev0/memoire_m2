<!DOCTYPE html>
<html lang="fr" data-theme="garden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Plateforme UMRED')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-base-100 text-base-content min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('public.partials.menu')

    <!-- Contenu -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('public.partials.footer')
</body>
</html>
