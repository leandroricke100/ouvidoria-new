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
            <a href="https://ouvidoria.test/"><img
                    src="https://digitaliza-institucional.s3.us-east-2.amazonaws.com/municipio-de-marilac/site/brasao.png"
                    alt="logo da prefeitura" /></a>
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
            <div>
                <button onclick="modalSair()" class="user"><i class="fas fa-user-alt"></i>
                    {{ $usuario['nome_completo'] }}<i class="fas fa-caret-down" style="margin-left: 4px"></i></button>

                <div class="modal-sair" style="display: none">
                    <button onclick="sair()" class="sair"><i class="fas fa-power-off"
                            style="margin-right: 5px"></i>Sair</button>
                </div>
            </div>
        @else
            <div class="login-cad">
                <a onclick="openModalLogin()">Entrar</a>
                @if (isset($cadastro) && $cadastro)
                    <a class="cadastro" href="https://ouvidoria.test/cadastro">Cadastro</a>
                @endif
            </div>
        @endif
    </div>

    <div class="modal-login" style="display: none;">
        <button class="close-modal" onclick="closeModal()"><i class="fas fa-times-circle"></i></button>
        @include('components.comp-login')
    </div>

</header>




@if (isset($banner) && $banner)
    <section class="banner-header">

        <div class="backgound-banner">
            <div class="icon-back">
                <a href="https://ouvidoria.test"><i class="fas fa-chevron-left"></i></a>
            </div>
            <h1><i class="fas {{ $icon ?? 'fa-bullhorn' }}"></i> {{ $titulo_banner ?? 'Sem título' }}</h1>
            <p>{{ $subtitulo_banner ?? '' }}</p>
            {!! isset($subtitulo_banner_2) ? '<p>' . $subtitulo_banner_2 . '</p>' : '' !!}
        </div>
    </section>
@endif
