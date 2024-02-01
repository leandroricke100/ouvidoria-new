@push('head')
    <link href="{{ asset('css/comp-config.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <script src="{{ asset('js/comp-config.js') }}"></script>
@endpush



<section class="config-section">

    <div class="bloco">
        <button onclick="modalMenu()" class="menus"><i class="fas fa-bars"></i>Menus</button>
        <button onclick="modalConta()" class="minhaConta"><i class="fas fa-user-cog"></i></i>Minha Conta</button>
    </div>


    <div class="div-padding">
        <div class="menu">
            teste1
        </div>

        <div class="conta" style="display: none">
            minha conta
        </div>
    </div>


</section>
