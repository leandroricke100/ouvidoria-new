@extends('layout.layout-global', ['titulo' => 'Meus atendimentos'])

@push('head')
    <link href="{{ asset('css/page-atendimentos.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('conteudo')
    @include('components.comp-header', [
        'banner2' => true,
        '$titleBanner2' => 'Meu Inbox • Minhas solicitações',
    ])

    <section class="bloco-atendimentos">
        <div class="div-padding">
            <div class="atendimento">
                <div class="number-atendimento">
                    <span class="title-atendi">Atendimento 333/2024</span>
                    <p>N° 593.617.060</p>
                </div>

                <div class="assunto">
                    <span class="title">Canal de esgoto</span>
                    <span class="prioridade">Urgente</span>
                </div>
                <div class="data">
                    <span class="title-movimentacao">Ultima movimentação</span>
                    <p>24/01/2024</p>
                </div>
            </div>
            <div class="atendimento">
                <div class="number-atendimento">
                    <span class="title-atendi">Atendimento 333/2024</span>
                    <p>N° 593.617.060</p>
                </div>

                <div class="assunto">
                    <span class="title">Canal de esgoto</span>
                    <span class="prioridade">Urgente</span>
                </div>
                <div class="data">
                    <span class="title-movimentacao">Ultima movimentação</span>
                    <p>24/01/2024</p>
                </div>
            </div>

        </div>
    </section>
    @include('components.comp-footer')
@endsection
