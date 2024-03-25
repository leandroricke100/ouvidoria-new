@extends('layout.layout-global', ['titulo' => 'Página Transparência'])

@push('head')
    <link href="{{ asset('css/pages/page-transparencia.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        $(document).ready(function() {
            // Opções para o primeiro gráfico (radialBar)
            var options1 = {
                chart: {
                    height: 400,
                    type: 'radialBar',
                },
                series: [{{ $classificacoesPorcentagem }}],
                labels: ['{{ $classificacoesPorcentagem == 0 ? 'Sem classificação' : 'Avaliação' }}'],

            };

            // Opções para o segundo gráfico (bar)
            var options2 = {

                chart: {
                    type: 'bar',
                    height: 400,
                    stackType: "100%"
                },
                plotOptions: {
                    bar: {
                        horizontal: true
                    }
                },
                series: [{
                    data: [
                        @foreach ($porcentagemAssunto as $assunto => $porcentagem)
                            {
                                x: '{{ $assunto }}',
                                y: {{ $porcentagem }},
                            },
                        @endforeach
                    ]
                }],

            };



            var options3 = {
                chart: {
                    type: 'donut',
                    height: 400,
                },
                series: [

                    @foreach ($manifestacoesPorcentagem as $manifestacao => $porcentagem)
                        {{ $porcentagem }},
                    @endforeach

                ],
                labels: [
                    //se tiver setado o valor de $manifestacaoTipo, ele vai exibir o q quantidade queryAtendimentosManifestacao se nao manifestacoesPorcentagem

                    @foreach ($manifestacoesPorcentagem as $manifestacao => $porcentagem)
                        '{{ $manifestacao }}',
                    @endforeach


                ]
            }

            var options4 = {
                plotOptions: {
                    bar: {
                        distributed: true
                    }
                },
                chart: {
                    type: 'bar',
                    height: 400,
                    width: '60%'
                },
                series: [{
                    data: [
                        @if (isset($filtro['generos']) && $filtro['generos'] != '')
                            {
                                x: '',
                                y: '{{ $porcentagemGenero }}',
                            },
                        @else
                            @foreach ($porcentagemGenero as $genero => $porcentagem)
                                {
                                    x: '{{ $genero }}',
                                    y: {{ $porcentagem }},
                                },
                            @endforeach
                        @endif

                    ]
                }]
            };


            var options5 = {
                chart: {
                    type: 'bar',
                    height: 400,
                    stackType: "100%"
                },
                plotOptions: {
                    bar: {
                        horizontal: true
                    }
                },
                colors: ['#56BDCA'],
                series: [{
                    data: [
                        @if (isset($filtro['faixaEtaria']) && $filtro['faixaEtaria'] != '')
                            {
                                x: '{{ $filtro['faixaEtaria'] }}' ,
                                y: '{{ $porcentagemIdade }}',
                            },
                        @else

                            @foreach ($porcentagemIdade as $idade => $porcentagem)
                                {
                                    x: '{{ $idade }}',
                                    y: {{ $porcentagem }},
                                },
                            @endforeach
                        @endif
                    ]
                }],

            };

            var options6 = {
                chart: {
                    height: 400,
                    type: 'radialBar',
                },
                series: ['{{$porcentagemDentroDoPrazo}}'],
                labels: ['{{ $mesAtual }}'],
            };

            // Renderizar o primeiro gráfico
            var chart1 = new ApexCharts(document.querySelector("#chart"), options1);
            chart1.render();

            // Renderizar o segundo gráfico
            var chart2 = new ApexCharts(document.querySelector("#assunto"), options2);
            chart2.render();

            var chart3 = new ApexCharts(document.querySelector("#tipoManifestacao"), options3);
            chart3.render();

            var chart4 = new ApexCharts(document.querySelector("#genero"), options4);
            chart4.render();

            var chart5 = new ApexCharts(document.querySelector("#idade"), options5);
            chart5.render();

            var chart6 = new ApexCharts(document.querySelector("#resposta"), options6);
            chart6.render();
        });
    </script>
@endpush

@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'titulo_banner' => 'Transparência',
    ])
    <main>
        <section>


            <div class="container-pesquisar">

                <div class="title-pequisar">
                    <h2>Busca Detalhada</h2>
                </div>

                <form method="get" class="itens-pesquisar">

                    <div class="wrap">

                        {{-- <div class="field" style="flex-basis: 15%">
                            <label for="assuntoPrincipal">Pincipais Assuntos</label>
                            <select name="assuntoPrincipal" id="assuntoPrincipal">
                                <option {{ isset($filtro['sigiloso']) && $filtro['sigiloso'] == '' ? 'selected' : '' }} selected value="">Ver todos</option>
                                <option {{ isset($filtro['sigiloso']) && $filtro['sigiloso'] == '1' ? 'selected' : '' }} value="1">Sim</option>
                            </select>
                        </div> --}}


                        <div class="field" style="flex-basis: 24%">
                            <label for="manifestacaoTipo">Tipos manifestação</label>
                            <select name="manifestacaoTipo" id="manifestacaoTipo">
                                <option {{ isset($filtro['manifestacaoTipo']) && $filtro['manifestacaoTipo'] == '' ? 'selected' : '' }} value="" selected>Ver todos</option>
                                <option {{ isset($filtro['manifestacaoTipo']) && $filtro['manifestacaoTipo'] == 'Sugestão' ? 'selected' : '' }} value="Sugestão">Sugestão</option>
                                <option {{ isset($filtro['manifestacaoTipo']) && $filtro['manifestacaoTipo'] == 'Denúncia' ? 'selected' : '' }} value="Denúncia">Denúncia</option>
                                <option {{ isset($filtro['manifestacaoTipo']) && $filtro['manifestacaoTipo'] == 'Solicitação' ? 'selected' : '' }} value="Solicitação">Solicitação</option>
                                <option {{ isset($filtro['manifestacaoTipo']) && $filtro['manifestacaoTipo'] == 'Simplifique' ? 'selected' : '' }} value="Simplifique">Simplifique</option>
                                <option {{ isset($filtro['manifestacaoTipo']) && $filtro['manifestacaoTipo'] == 'Informação' ? 'selected' : '' }} value="Informação">Informação</option>
                                <option {{ isset($filtro['manifestacaoTipo']) && $filtro['manifestacaoTipo'] == 'Elogio' ? 'selected' : '' }} value="Elogio">Elogio</option>
                                <option {{ isset($filtro['manifestacaoTipo']) && $filtro['manifestacaoTipo'] == 'Reclamação' ? 'selected' : '' }} value="Reclamação">Reclamação</option>
                            </select>
                        </div>

                        <div class="field" style="flex-basis: 24%">
                            <label for="generos">Gênero</label>
                            <select name="generos" id="generos">
                                <option {{ isset($filtro['generos']) && $filtro['generos'] == '' ? 'selected' : '' }} value="" selected>Ver todos</option>
                                <option {{ isset($filtro['generos']) && $filtro['generos'] == 'Masculino' ? 'selected' : '' }} value="Masculino">Masculino</option>
                                <option {{ isset($filtro['generos']) && $filtro['generos'] == 'Feminino' ? 'selected' : '' }} value="Feminino">Feminino</option>
                                <option {{ isset($filtro['generos']) && $filtro['generos'] == 'Não informado' ? 'selected' : '' }} value="Não informado">Não informado</option>
                            </select>
                        </div>

                        <div class="field" style="flex-basis: 24%">
                            <label for="faixaEtaria">Faixa Etária</label>
                            <select name="faixaEtaria" id="faixaEtaria">
                                <option {{ isset($filtro['faixaEtaria']) && $filtro['faixaEtaria'] == '' ? 'selected' : '' }} value="" selected>Ver todos</option>
                                <option {{ isset($filtro['faixaEtaria']) && $filtro['faixaEtaria'] == '18-28' ? 'selected' : '' }} value="18-28">18-28</option>
                                <option {{ isset($filtro['faixaEtaria']) && $filtro['faixaEtaria'] == '29-38' ? 'selected' : '' }} value="29-38">29-38</option>
                                <option {{ isset($filtro['faixaEtaria']) && $filtro['faixaEtaria'] == '39-48' ? 'selected' : '' }} value="39-48">39-48</option>
                                <option {{ isset($filtro['faixaEtaria']) && $filtro['faixaEtaria'] == '+ 48' ? 'selected' : '' }} value="+ 48">+ 48</option>
                            </select>
                        </div>

                        {{-- <div class="field" style="flex-basis: 15%">
                            <label for="prazoResposta">Resposta no prazo</label>
                            <select name="prazoResposta" id="prazoResposta">
                                <option {{ isset($filtro['situacao']) && $filtro['situacao'] == '' ? 'selected' : '' }} value="" selected>Ver todos</option>
                                <option {{ isset($filtro['situacao']) && $filtro['situacao'] == 'Novo' ? 'selected' : '' }} value="Novo">Sim</option>
                            </select>
                        </div> --}}

                        <div class="field" style="flex-basis: 24%">
                            <label for="mes">Mês</label>
                            <select name="mes">
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == '' ? 'selected' : '' }} value="">Mês Atual</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Janeiro' ? 'selected' : '' }} value="1">Janeiro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Fevereiro' ? 'selected' : '' }} value="2">Fevereiro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Março' ? 'selected' : '' }} value="3">Março</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Abril' ? 'selected' : '' }} value="4">Abril</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Maio' ? 'selected' : '' }} value="5">Maio</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Junho' ? 'selected' : '' }} value="6">Junho</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Julho' ? 'selected' : '' }} value="7">Julho</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Agosto' ? 'selected' : '' }} value="8">Agosto</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Setembro' ? 'selected' : '' }} value="9">Setembro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Outubro' ? 'selected' : '' }} value="10">Outubro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Novembro' ? 'selected' : '' }} value="11">Novembro</option>
                                <option {{ isset($filtro['mes']) && $filtro['mes'] == 'Dezembro' ? 'selected' : '' }} value="12">Dezembro</option>
                            </select>
                        </div>

                        <div class="field" style="flex-basis: 24%">
                            <label for="ano">Ano</label>
                            <select name="ano" id="ano">
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '' ? 'selected' : '' }} selected value="">Ano Atual</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2024' ? 'selected' : '' }} value="2024">2024</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2023' ? 'selected' : '' }} value="2023">2023</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2022' ? 'selected' : '' }} value="2022">2022</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2021' ? 'selected' : '' }} value="2021">2021</option>
                                <option {{ isset($filtro['ano']) && $filtro['ano'] == '2020' ? 'selected' : '' }} value="2020">2020</option>
                            </select>
                        </div>

                        <div class="field" style="flex-basis: 24%">
                            <label for="periodo_inicial">Período Inicial</label>
                            <input type="date" name="periodo_inicial" id="periodo_inicial">
                        </div>

                        <div class="field" style="flex-basis: 24%">
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

            <div class="ano">
                <h2>Ano de referencia: {{ $ano }}.</h2>
                <span><strong>Obs.:</strong> os valores são computados mensalmente (dados referentes ao mês <strong>{{ $mesAtual }}</strong> ).</span>
            </div>

            <div class="atendimento">
                <h1>Atendimento</h1>
                <div class="bloco">
                    <div class="qnt-manifestacao">
                        <p>MANIFESTAÇÕES RECEBIDAS</p>
                        @if ($quantidade == null)
                            <span>0</span>
                        @else
                            <span>{{ $quantidade }}</span>
                        @endif
                    </div>


                    <div class="qnt-manifestacao">
                        <p>MANIFESTAÇÕES RESPONDIDAS</p>
                        <span>{{ $quantidadeRespostas }}</span>
                    </div>

                </div>
                <div class="bloco">
                    <div class="qnt-manifestacao">
                        <p>DENTRO DO PRAZO</p>
                        <span>{{$porcentagemDentroDoPrazo}} %</span>
                    </div>


                </div>
            </div>

            <span id="title-satisfacao">Indice de Satisfação</span>
            <div id="chart"></div>

            <span id="title-assunto">Principais Assuntos</span>


            <div id="assunto"></div>
            <span id="grafico-porcentagem">Porcentagem (%)</span>


            <span id="title-manifestacao">Tipos manifestação</span>
            <div id="tipoManifestacao"></div>

            <span id="title-genero">Gênero Solicitantes</span>
            <div id="genero"></div>
            <span id="grafico-porcentagem">
                @if (isset($filtro['generos']) && $filtro['generos'] != '')
                    <strong>Quantidade {{ $filtro['generos'] }}: {{$porcentagemGenero}}. </strong>
                @else
                    Porcentagem (%)
                @endif
            </span>

            <span id="title-idade">Faixa Etária Solicitantes</span>
            <div id="idade"></div>
            <span id="grafico-porcentagem">
                @if (isset($filtro['faixaEtaria']) && $filtro['faixaEtaria'] != '')
                    <strong>Quantidade: {{$porcentagemIdade  }} </strong>
                @else
                    Porcentagem (%)
                @endif
            </span>

            <span id="resposta-porcentagem">Resposta no prazo</span>
            <div id="resposta"></div>

            <div class="text-bottom">
                <p>Dados disponibilizados conforme Lei 13.460 e Lei 12.527.</p>
            </div>

        </section>
    </main>

    @include('components.comp-footer')
@endsection
