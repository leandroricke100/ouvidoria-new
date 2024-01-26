@extends('layout.layout-global', ['titulo' => 'Meus atendimentos'])

@push('head')
    <script src="{{ asset('js/page-atendimentos.js') }}"></script>
    <link href="{{ asset('css/page-atendimentos.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('conteudo')
    @include(
        'components.comp-header',
    
        [
            'banner' => true,
            'titulo_banner' => 'Meu Inbox - Minhas solicitações',
        ]
    )

    <section class="bloco-atendimentos">
        <div class="bloco">
            <button class="aberto"><i class="fas fa-arrow-down"></i>Em aberto (1)</button>
            <button class="arquivado"><i class="fas fa-download"></i>Arquivado (1)</button>
        </div>
        <div class="div-padding">
            <table width="100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>De</th>
                        <th>Assunto</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="number-atendimento">
                                <span class="title-atendi">Atendimento 333/2024</span>
                                <p>N° 593.617.060</p>
                                <p class="dataHora">24/01/2024 08:32</p>
                            </div>
                        </td>
                        <td>
                            <div class="sigilo">
                                <span class="sigiloso">Sigiloso</span>
                            </div>
                        </td>
                        <td>
                            <div class="assunto">
                                <span class="title">Canal de esgoto</span>
                                <span class="prioridade">Urgente</span>
                            </div>
                        </td>
                        <td>
                            <div class="data">
                                <p>Há 22 horas</p>
                                <span><i class="far fa-paperclip"></i></span>
                                <span><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    @include('components.comp-footer')
@endsection
