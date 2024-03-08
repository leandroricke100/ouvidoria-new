@extends('layout.layout-global', ['titulo' => 'Meus atendimentos'])

@push('head')
    <script src="{{ asset('js/pages/page-atendimentos.js') }}"></script>
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <link href="{{ asset('css/pages/page-atendimentos.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@php
    $usuario = session('usuario');
    // dd($usuario->administrador());
@endphp

@section('conteudo')
    @include(
        'components.comp-header',

        [
            'banner' => true,
            'titulo_banner' => $usuario->admin ? 'Solicitações' : 'Inbox - Minhas Solicitações',
        ]
    )

    <main>


        <section class="bloco-atendimentos">
            <div class="bloco">
                <button id="btnAberto" onclick="modalAberto()" class="aberto ativo"><i class="fas fa-arrow-down"></i>Em
                    aberto
                    ({{ $atendimentosAberto }})</button>
                <button id="btnArquivado" onclick="modalArquivado()" class="arquivado"><i class="fas fa-download"></i>Arquivado
                    ({{ $atendimentosArquivado }})</button>
            </div>


            <div class="div-padding">
                @if ($atendimentos)
                    <table width="100%" class="bloco-aberto">
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
                                @if ($atendimento->situacao !== 'Finalizado')
                                    <div id="emAberto" class="emAberto">
                                        <tr>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->id }}">
                                                    <div class="number-atendimento">
                                                        <span class="title-atendi">Atendimento
                                                            {{ $atendimento->id }}/{{ $atendimento->ano }}</span>
                                                        <p>N° {{ $atendimento->codigo }}</p>
                                                        <p class="dataHora">{{ $atendimento->created_at }}</p>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="sigilo">
                                                        @if ($atendimento->sigiloso == 1)
                                                            <span class="sigiloso">Sigiloso</span>
                                                        @else
                                                            <span class="sigiloso">Sem Sigilo</span>
                                                        @endif
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="assunto">
                                                        <span class="title">{{ $atendimento->assunto }}</span>
                                                        <span class="prioridade">{{ $atendimento->prioridade }}</span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="data">
                                                        <p>Há {{ $atendimento->tempo_atras }}</p>
                                                        {{-- @if ($mensagens->id_atendimento == $usuario->id && $mensagens->arquivo !== null)
                                        <span><i class="far fa-paperclip"></i></span>
                                    @endif --}}
                                                        @if ($atendimento->endereco)
                                                            <span><i class="fas fa-map-marker-alt"></i></span>
                                                        @endif


                                                    </div>
                                                </a>
                                            </td>
                                        </tr>

                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>


                    <table width="100%" class="bloco-arquivado" style="display: none">
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
                                @if ($atendimento->situacao == 'Finalizado')
                                    <div id="emAberto" class="emAberto">
                                        <tr>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->id }}">
                                                    <div class="number-atendimento">
                                                        <span class="title-atendi">Atendimento
                                                            {{ $atendimento->id }}/{{ $atendimento->ano }}</span>
                                                        <p>N° {{ $atendimento->codigo }}</p>
                                                        <p class="dataHora">{{ $atendimento->created_at }}</p>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="sigilo">
                                                        @if ($atendimento->sigiloso == 1)
                                                            <span class="sigiloso">Sigiloso</span>
                                                        @else
                                                            <span class="sigiloso">Sem Sigilo</span>
                                                        @endif
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="assunto">
                                                        <span class="title">{{ $atendimento->assunto }}</span>
                                                        <span class="prioridade {{$atendimento->prioridade}}">{{ $atendimento->prioridade }}</span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="data">
                                                        <p>Há {{ $atendimento->tempo_atras }}</p>
                                                        <span><i class="far fa-paperclip"></i></span>
                                                        <span><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>

                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h1>Nenhum ticket</h1>
                @endif
            </div>



        </section>

    </main>

    @include('components.comp-footer')
@endsection
