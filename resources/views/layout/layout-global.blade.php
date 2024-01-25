<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $titulo }}</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}" />

    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/fontawesome-pro.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet"> --}}

    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    @stack('head')
</head>

<body>

    @yield('conteudo')
    @stack('foot')
</body>

</html>
