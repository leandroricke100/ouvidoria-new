@extends('layout.layout-global', ['titulo' => 'Página Login'])

@push('head')
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
@endpush

@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'titulo_banner' => 'Atendimento',
        'subtitulo_banner' => 'Atendimento ao Cidadão: Ouvidoria',
        'subtitulo_banner_2' => 'Envie sua demanda para a Prefeitura',
    ])
    <main>
        <div class="container-login">

            @include('components.comp-sigilo', ['sigilo' => true])

            @include('components.comp-login', ['modalLoginInput' => true])

        </div>
    </main>
    @include('components.comp-footer')
@endsection
