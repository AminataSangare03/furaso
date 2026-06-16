<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <title>@yield('title', 'Mon espace') — Furaso</title>
    <link rel="stylesheet" href="{{ asset('css/furaso.css') }}">
</head>
<body>
    @include('partials.navbar')

    <div class="dash">
        @include('partials.sidebar')
        <div class="dash-main">
            @include('partials.flash')
            @yield('content')
        </div>
    </div>
</body>
</html>
