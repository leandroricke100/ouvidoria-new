@extends('layout.layout-global', ['titulo' => 'Meus atendimentos'])

@push('head')
    {{-- <script src="{{ asset('js/page-atendimentos.js') }}"></script> --}}
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
                    @foreach ($atendimentos as $atendimento)
                        <tr>
                            <td>
                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}" target="blank">
                                    <div class="number-atendimento">
                                        <span class="title-atendi">Atendimento
                                            {{ $atendimento->numero }}/{{ $atendimento->ano }}</span>
                                        <p>N° {{ $atendimento->codigo }}</p>
                                        <p class="dataHora">{{ $atendimento->created_at }}</p>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}" target="blank">
                                    <div class="sigilo">
                                        @if ($atendimento->sigiloso == 1)
                                            <span class="sigiloso">Sigiloso</span>
                                        @else
                                            <span class="sigiloso">Sem Sigiloso</span>
                                        @endif
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}" target="blank">
                                    <div class="assunto">
                                        <span class="title">{{ $atendimento->assunto }}</span>
                                        <span class="prioridade">{{ $atendimento->prioridade }}</span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}" target="blank">
                                    <div class="data">
                                        <p>Há {{ $atendimento->tempo_atras }}</p>
                                        <span><i class="far fa-paperclip"></i></span>
                                        <span><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </section>
    @include('components.comp-footer')
@endsection
