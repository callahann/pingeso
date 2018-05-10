<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>USACH - @yield('title')</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <img src="{{ asset('images/usach.png') }}" class="navbar-brand">
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse" style="padding-left: 10em">
                    <!-- Left Side Of Navbar -->
                    <a href="/" class="btn navbar-btn @if($pagina == 'inicio')active @endif" role="button">Inicio</a>
                    <a href="/declaraciones" class="btn navbar-btn @if($pagina == 'form')active @endif" role="button">Informe Actividades</a>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>