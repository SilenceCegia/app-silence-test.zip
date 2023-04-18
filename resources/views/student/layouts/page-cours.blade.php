<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="icon" type="image/png" sizes="32x32" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="apple-touch-icon" sizes="180x180" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


</head>

<body style="background: {{ $contentBackground }};">
    @guest
    @else
        <div id="app" class="container-fluid" style="padding: 8px 0; margin-bottom: 16px; min-height: 0;">
            @include('student.components.topbar')
        </div>
        <div class="container">

            <div class="row">
                <div class="col-md-1">
                    <a href="/student/ateliers">
                        <span style="background: rgba(255,255,255,0.1); padding:8px 16px; color:#AAA; border-radius:4px;">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                    </a>
                </div>
                <div class="col-md-10" style="padding: 0 16px 32px 32px;">
                    @yield('content')
                </div>
            </div>
        </div>

        @yield('before-end-body')

    @endguest
</body>

</html>
