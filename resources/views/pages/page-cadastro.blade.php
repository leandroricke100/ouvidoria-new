@extends('layout.layout-global', ['titulo' => 'Página cadastro'])

@section('conteudo')
    @include(
        'components.comp-header',
        [
            'banner' => true,
            'titulo_banner' => 'Atendimentos',
            'subtitulo_banner' => 'Atendimento ao Cidadão: Ouvidoria',
            'subtitulo_banner_2' => 'Envie sua demanda e acompanhe o andamento',
        ]
    )
    <main>
        @include('components.comp-sigilo', ['sigilo' => true])

        @include('components.comp-cadastro')
    </main>

    @include('components.comp-footer')
@endsection
