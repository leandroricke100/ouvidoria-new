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
            <a href="">Entrar</a>
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

    <div class="header-right">
        <a>Entrar</a>
        <a>Cadastro</a>
    </div>
</header>
