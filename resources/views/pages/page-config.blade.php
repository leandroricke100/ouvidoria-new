@extends('layout.layout-global', ['titulo' => 'Configuração'])

@push('head')
@endpush

@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'titulo_banner' => 'Configuração',
    ])

    @include('components.comp-config')

    @include('components.comp-footer')
@endsection
