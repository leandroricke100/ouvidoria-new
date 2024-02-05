@extends('layout.layout-global', ['titulo' => 'Minha Conta'])

@push('head')
    <link href="{{ asset('css/pages/page-minhaConta.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/pages/page-minhaConta.js') }}"></script>
    <script src="{{ asset('js/tools/jquery.mask.js') }}"></script>
@endpush

@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'titulo_banner' => 'minha Conta',
    ])


    <section class="bloco-1">
        <div class="bloco">
            <button id="btnMinhaConta" type="button" class="minhaConta" onclick="minhaContaUser({{ $user->id }})"><i
                    class="fas fa-user-cog"></i></i>Minha
                Conta</button>
        </div>

        <div class="div-padding">
            <div class="conta">
                @include('components.comp-cadastro')
            </div>
        </div>
    </section>


    @include('components.comp-footer')
@endsection
