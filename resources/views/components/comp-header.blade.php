@push('head')
    <script src="{{ asset('js/comp-header.js') }}"></script>
    <link href="{{ asset('css/comp-header.css') }}?v={{ time() }}" rel="stylesheet">
@endpush


<header id="comp-header">
    <div class="header-left">
        <div class="menu-left-modal" style="display: none">
            <button class="btn-menu-mobile" onclick="openMenuMobile()"><i class="fas fa-bars"></i></button>
        </div>

        <div class="img-brasao">
            <img src="https://otimize-edoc.s3.amazonaws.com/edoc_310/logo_petrolina.png?v=" alt="logo da prefeitura" />
        </div>

        <div class="div-codigo">
            <input type="text" id="codigo" placeholder="Buscar por código" /><button class="btn-search-codigo"><i
                    class="fas fa-search"></i></button>
        </div>


        <div class="login-modal-mobile" style="display: none">
            <button onclick="openModalLogin()">Entrar</button>
            <a href="">Cadastro</a>
        </div>


        {{-- <div class="btn-modal-search">
            <button class="btn-search-number"><i class="fas fa-caret-down" onclick="openSearchBtn()"></i></button>

            <div class="search-options" style="display: none">
                <a href="">Buscar por código</a>
                <a href>Buscar por número + cpf/cnpj</a>
            </div>
        </div> --}}
    </div>

    @php
        $usuario = ['nome_completo' => 'Leandro'];
    @endphp

    <div class="header-right">
        @if (isset($usuario))
            <a href="https://ouvidoria.test/" class="inicio"><i class="fas fa-home"></i> Início</a>
            <a class="inicio" href="https://ouvidoria.test/atendimentos"><i class="fas fa-inbox"></i>Meu inbox</a>
            <a class="inicio"><i class="fas fa-user-alt"></i> {{ $usuario['nome_completo'] }}</a>
        @else
            <a onclick="openModalLogin()">Entrar</a>
            <a>Cadastro</a>
        @endif
    </div>

    <div class="modal-login" style="display: none;">
        <button class="close-modal" onclick="closeModal()"><i class="fas fa-times-circle"></i></button>
        @include('components.comp-login')
    </div>

</header>




@if (isset($banner) && $banner)
    <section class="container-main">
        <h1><i class="fas {{ $icon ?? 'fa-bullhorn' }}"></i> {{ $titulo_banner ?? 'Sem título' }}</h1>
        <p>{{ $subtitulo_banner ?? 'Sem subtítulo' }}</p>
        {!! isset($subtitulo_banner_2) ? '<p>' . $subtitulo_banner_2 . '</p>' : '' !!}
    </section>
@endif

@if (isset($banner2) && $banner2)
    <div class="container-main2">
        <h2>{{ $titleBanner2 ?? 'Central de Atendimento • Prefeitura de Petrolina' }}</h2>
        {!! isset($titleBanner2) ? '<p>' . $titleBanner2 . '</p>' : '' !!}
    </div>
@endif
