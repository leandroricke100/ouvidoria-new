@inject('OuvidoriaConfiguracao', 'App\Models\OuvidoriaConfiguracao')



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

    <meta name="description" content="Bem-vindo à Ouvidoria do(a) {{ $OuvidoriaConfiguracao->first()->titulo }}. Aqui, você pode fazer suas solicitações, apresentar sugestões e relatar questões relacionadas aos serviços oferecidos pelo nosso órgão. Utilize este canal para expressar suas preocupações e contribuir para melhorias. Estamos aqui para ouvir e responder às suas necessidades. Faça sua solicitação agora e participe ativamente do aprimoramento dos serviços públicos." />

    {{-- <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet"> --}}

    {{-- Montserrat --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <script src="{{ asset('js/tools/jquery.mask.js') }}"></script>

    <script src="{{ asset('js/tools/toastr.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/tools/toastr.min.css') }}" />

    <script src="{{ asset('js/global.js') }}"></script>

    @stack('head')
</head>

<body>
    @yield('conteudo')

    @stack('foot')
</body>

</html>
