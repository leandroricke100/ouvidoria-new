@inject('Helper', 'App\Helper\Helper')

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

            <div class="container-pesquisar">

                <div class="title-pequisar">
                    <h2>Busca Detalhada</h2>
                </div>

                <form method="get" class="itens-pesquisar">

                    <div class="wrap">

                        <div class="field" style="flex-basis: 100%">
                            <label for="palavra_chave">Palavra chave</label>
                            <input type="text" name="palavra_chave" id="palavra_chave" placeholder="Ex.: Orçamento">
                        </div>

                        <div class="field" style="flex-basis: 5%">
                            <label for="sigiloso">Sigiloso</label>
                            <select name="sigiloso" id="sigiloso">
                                <option {{ isset($filtro['sigiloso']) && $filtro['sigiloso'] == '' ? 'selected' : '' }} selected value="">Ver todos</option>
                                <option {{ isset($filtro['sigiloso']) && $filtro['sigiloso'] == '0' ? 'selected' : '' }} value="0">Não</option>
                                <option {{ isset($filtro['sigiloso']) && $filtro['sigiloso'] == '1' ? 'selected' : '' }} value="1">Sim</option>
                            </select>
                        </div>


                        <div class="field" style="flex-basis: 5%">
                            <label for="prioridade">Prioridade</label>
                            <select name="prioridade" id="prioridade">
                                <option {{isset($filtro['prioridade']) && $filtro['prioridade'] == '' ? 'selected' : '' }} value="" selected>Ver todos</option>
                                <option {{isset($filtro['prioridade']) && $filtro['prioridade'] == 'Baixo' ? 'selected' : '' }} value="Baixo">Baixo</option>
                                <option {{isset($filtro['prioridade']) && $filtro['prioridade'] == 'Média' ? 'selected' : '' }} value="Média">Média</option>
                                <option {{isset($filtro['prioridade']) && $filtro['prioridade'] == 'Alta' ? 'selected' : '' }} value="Alta">Alta</option>
                                <option {{isset($filtro['prioridade']) && $filtro['prioridade'] == 'Urgente' ? 'selected' : '' }} value="Urgente">Urgente</option>
                            </select>
                        </div>

                        <div class="field" style="flex-basis: 5%">
                            <label for="situacao">Situação</label>
                            <select name="situacao" id="situacao">
                                <option {{isset($filtro['situacao']) && $filtro['situacao'] == '' ? 'selected' : '' }} value="" selected>Ver todos</option>
                                <option {{isset($filtro['situacao']) && $filtro['situacao'] == 'Novo' ? 'selected' : '' }}  value="Novo">Novo</option>
                                <option {{isset($filtro['situacao']) && $filtro['situacao'] == 'Andamento' ? 'selected' : '' }}  value="Andamento">Andamento</option>
                                <option {{isset($filtro['situacao']) && $filtro['situacao'] == 'Finalizado' ? 'selected' : '' }}  value="Finalizado">Fechado</option>
                            </select>
                        </div>

                        <div class="field" style="flex-basis: 10%">
                            <label for="mes">Mês</label>
                            <select name="mes">
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '' ? 'selected' : '' }} selected value="">Ver todos</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '1' ? 'selected' : '' }} value="1">Janeiro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '2' ? 'selected' : '' }} value="2">Fevereiro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '3' ? 'selected' : '' }} value="3">Março</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '4' ? 'selected' : '' }} value="4">Abril</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '5' ? 'selected' : '' }} value="5">Maio</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '6' ? 'selected' : '' }} value="6">Junho</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '7' ? 'selected' : '' }} value="7">Julho</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '8' ? 'selected' : '' }} value="8">Agosto</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '9' ? 'selected' : '' }} value="9">Setembro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '10' ? 'selected' : '' }} value="10">Outubro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '11' ? 'selected' : '' }} value="11">Novembro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '12' ? 'selected' : '' }} value="12">Dezembro</option>
                            </select>
                        </div>

                        <div class="field" style="flex-basis: 5%">
                            <label for="ano">Ano</label>
                            <select name="ano" id="ano">
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '' ? 'selected' : '' }} value="" selected>Ver todos</>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2024' ? 'selected' : '' }} value="2024">2024</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2023' ? 'selected' : '' }} value="2023">2023</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2022' ? 'selected' : '' }} value="2022">2022</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2021' ? 'selected' : '' }} value="2021">2021</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2020' ? 'selected' : '' }} value="2020">2020</option>
                            </select>
                        </div>

                        <div class="field" style="flex-basis: 10%">
                            <label for="periodo_inicial">Período Inicial</label>
                            <input type="date" name="periodo_inicial" id="periodo_inicial">
                        </div>

                        <div class="field" style="flex-basis: 10%">
                            <label for="periodo_final">Período Final</label>
                            <input type="date" name="periodo_final" id="periodo_final">
                        </div>

                    </div>


                    <div class="container button">
                        <div>

                        </div>

                        <div class="buttonBuscar">
                            <button type="submit" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>



            </div>

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
                                <th>Data do Atendimento</th>
                                <th>Atendimento</th>
                                <th>Sigilo</th>
                                <th>Assunto</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($atendimentos as $atendimento)
                                @if ($atendimento->situacao !== 'Finalizado')
                                    <div id="emAberto" class="emAberto">
                                        <tr>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="data">

                                                        <p class="dataHora">{{ date('d/m/Y H:i:s', strtotime($atendimento->created_at)) }}</p>

                                                        @if ($atendimento->endereco)
                                                            <span><i class="fas fa-map-marker-alt"></i></span>
                                                        @endif


                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->id }}">
                                                    <div class="number-atendimento">
                                                        <span class="title-atendi atendimentoColor">N° Atendimento
                                                            {{ $atendimento->id }}/{{ $atendimento->ano }}</span>
                                                        <p class="atendimentoColor">N° Protocolo {{ $atendimento->codigo }}</p>
                                                        <p class="tempoAtras">Há {{ $atendimento->tempo_atras }}</p>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="sigilo">
                                                        @if ($atendimento->sigiloso == 1)
                                                            <span class="sigiloso">Sigiloso</span>
                                                        @else
                                                            <span class="semSigilo">Sem Sigilo</span>
                                                        @endif
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="assunto">

                                                        <span class="prioridade {{ $Helper->slugfy($atendimento->prioridade) }}">{{ $atendimento->prioridade }}</span>
                                                        <span class="title">{{ $atendimento->assunto }}</span>
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
                                <th>Data do Atendimento</th>
                                <th>Atendimento</th>
                                <th>Sigilo</th>
                                <th>Assunto</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($atendimentos as $atendimento)
                                @if ($atendimento->situacao == 'Finalizado')
                                    <div id="emAberto" class="emAberto">
                                        <tr>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="data">
                                                        <p class="dataHora">{{ $atendimento->created_at }}</p>

                                                        <span><i class="far fa-paperclip"></i></span>
                                                        <span><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->id }}">
                                                    <div class="number-atendimento">
                                                        <span class="title-atendi atendimentoColor">N° Atendimento
                                                            {{ $atendimento->id }}/{{ $atendimento->ano }}</span>
                                                        <p class="atendimentoColor">N° Protocolo {{ $atendimento->codigo }}</p>
                                                        <p class="tempoAtras">Há {{ $atendimento->tempo_atras }}</p>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="sigilo">
                                                        @if ($atendimento->sigiloso == 1)
                                                            <span class="sigiloso">Sigiloso</span>
                                                        @else
                                                            <span class="semSigilo">Sem Sigilo</span>
                                                        @endif
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="link-atendimento" href="/atendimento/{{ $atendimento->numero }}">
                                                    <div class="assunto">

                                                        <span class="prioridade {{ $Helper->slugfy($atendimento->prioridade) }}">{{ $atendimento->prioridade }}</span>
                                                        <span class="title">{{ $atendimento->assunto }}</span>
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
                    <h1 class="nenhumAtendimento">Nenhum Atendimento!
                    </h1>
                @endif
            </div>



        </section>

    </main>

    @include('components.comp-footer')
@endsection
