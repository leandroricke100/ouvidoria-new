@push('head')
    <link href="{{ asset('css/components/comp-config.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/components/comp-config.js') }}"></script>
@endpush



<section class="config-section">


    <div class="bloco">
        <div style="display: none;" id_usuario="{{ $usuario->id }}"></div>

        <button id="btnMinhaConta" onclick="modalConta({{ $usuario->id }})" class="minhaConta" ativo>
            <i class="fas fa-user-cog"></i> Minha Conta
        </button>
        @if ($usuario->admin)
            <button id="btnEndereco" onclick="modalEndereco({{ $usuario->id }})" class="menus" >
                <i class="fas fa-map-marker-check"></i> Endereço
            </button>
        @endif


    </div>


    <div class="div-padding">

        <div class="conta" style="{{ $usuario->admin ? 'display: none;' : '' }}">
            <h1>Meus Dados</h1>
            @include('components.comp-cadastro')
        </div>

        <div class="menuEndereco" style="display: none">
            <h1>Informações do Cabeçalho & Rodapé</h1>
        </div>

    </div>

</section>
