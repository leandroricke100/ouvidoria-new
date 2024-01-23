@extends('layout.layout-global', ['titulo' => 'Página Login'])

@push('head')
    <link href="{{ asset('css/page-login.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('conteudo')
    @include('components.comp-header')

    <div class="container-main">
        <h1><i class="fas fa-bullhorn"></i> Atendimentos</h1>
        <p>Atendimento ao Cidadão: Ouvidoria</p>
        <p>Envie sua demanda para a Prefeitura</p>
    </div>

    @include('components.comp-footer')
@endsection
