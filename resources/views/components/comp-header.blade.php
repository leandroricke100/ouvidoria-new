@push('head')
    <script src="{{ asset('js/components/comp-header.js') }}"></script>
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <script src="{{ asset('js/tools/jquery.mask.js') }}"></script>
    <link href="{{ asset('css/components/comp-header.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
@php
    $usuario = session('usuario') ?? null;
    $currentPage = request()->path();
@endphp

<header id="comp-header" class="{{ $currentPage == 'minhaconta' ? 'selected' : '' }}">
    <div class="conteudo">
        <div class="header-left">
            <div class="menu-left-modal" style="display: none">
                <button class="btn-menu-mobile" onclick="openMenuMobile()"><i class="fas fa-bars"></i></button>
            </div>

            <div class="img-brasao">
                <a href="/"><img src="{{ asset('asset/brasaocampanario.jpeg') }}" /></a>
            </div>

            <div class="div-codigo">
                <input type="text" id="codigo" placeholder="Buscar por código" /><button class="btn-search-codigo"><i class="fas fa-search" onclick="buscarCodigo()"></i></button>
            </div>


            <div class="login-modal-mobile" style="display: none">
                <button onclick="modalLoginUser()"><i class="fal fa-sign-in"></i> Entrar</button>
                <button onclick="cad()"><i class="fal fa-user-plus"></i> Cadastro</button>
            </div>


            {{-- <div class="btn-modal-search">
                <button class="btn-search-number"><i class="fas fa-caret-down" onclick="openSearchBtn()"></i></button>

                <div class="search-options" style="display: none">
                    <a href="">Buscar por código</a>
                    <a href>Buscar por número + cpf/cnpj</a>
                </div>
            </div> --}}
        </div>

        <div class="header-right">
            @if (isset($usuario) && $usuario->nome_completo)
                <!-- Usuário está logado -->
                <a href="/" class="inicio {{ $currentPage == '/' ? 'selected' : '' }}"><i class="fas fa-home"></i>
                    Início</a>
                <a class="inicio {{ $currentPage == 'atendimentos' ? 'selected' : '' }}" href="/atendimentos"><i
                       class="fas fa-inbox"></i>Meu inbox</a>

                <div>
                    <button class="user {{ $currentPage == 'configuracao' ? 'selected' : '' }}" onclick="modalSair()">
                        <i class="fas fa-user-alt"></i>
                        {{ explode(' ', $usuario->nome_completo)[0] }}
                        <i class="fas fa-caret-down" style="margin-left: 8px"></i>
                    </button>


                    <div class="modal-sair" style="display: none">
                        @if ($usuario->admin == 1)
                            <button onclick="configuracao()" class="configuracao">Configurações</button>
                        @else
                            <button onclick="configuracao()" class="configuracao"
                                    {{ $currentPage == 'configuracao' ? 'selected' : '' }}>Minha conta</button>
                        @endif
                        <button onclick="sair()" class="sair"><i class="fas fa-power-off"
                               style="margin-right: 5px"></i>Sair</button>
                    </div>
                </div>
            @else
                <div class="login-cad">

                    <a onclick="modalLoginUser()"><i class="fas fa-sign-in"></i> Entrar</a>
                    @if (isset($cadastro) && $cadastro)
                        <a class="cadastro" href="/cadastro"><i class="fas fa-user-plus"></i> Cadastro</a>
                    @endif
                </div>
            @endif
        </div>

        <div class="modal-login" style="display: none;">
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times-circle"></i></button>
            @include('components.comp-login', ['usuario' => $usuario ?? null])
        </div>
    </div>
</header>




@if (isset($banner) && $banner)
    <section class="banner-header">

        <div class="backgound-banner">
            @if (!isset($voltar) || $voltar)
                <div class="icon-back">
                    <a href="/"><i class="fas fa-chevron-left"></i></a>
                </div>
            @endif

            <h1><i class="fas {{ $icon ?? 'fa-bullhorn' }}"></i> {{ $titulo_banner ?? 'Sem título' }}</h1>
            <p>{{ $subtitulo_banner ?? '' }}</p>
            {!! isset($subtitulo_banner_2) ? '<p>' . $subtitulo_banner_2 . '</p>' : '' !!}
        </div>
    </section>
@endif
