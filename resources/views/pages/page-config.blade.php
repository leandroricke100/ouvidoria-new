@extends('layout.layout-global', ['titulo' => 'Configuração'])

@push('head')
@endpush

@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'titulo_banner' => 'Configuração',
    ])

    <main>
        @include('components.comp-config')
    </main>

    @include('components.comp-footer')
@endsection
