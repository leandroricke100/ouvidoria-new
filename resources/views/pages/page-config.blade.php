@extends('layout.layout-global', ['titulo' => 'Configuração'])

@push('head')
    <link href="{{ asset('css/comp-config.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
    
        'titulo_banner' => 'Configuração',
    ])

    @include('components.comp-config')
    @include('components.comp-footer')
@endsection
