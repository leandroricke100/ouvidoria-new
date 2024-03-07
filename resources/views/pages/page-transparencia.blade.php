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
                series: [{{ $porcentagemAvaliacao }}],
                labels: [''],
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
                    @foreach ($porcentagemManifestacao as $manifestacao => $porcentagem)
                        {{ $porcentagem }},
                    @endforeach
                ],
                labels: [
                    @foreach ($porcentagemManifestacao as $manifestacao => $porcentagem)
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
                        @foreach ($porcentagemGenero as $genero => $porcentagem)
                            {
                                x: '{{ $genero }}',
                                y: {{ $porcentagem }},
                            },
                        @endforeach
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
                    data: [{
                        x: 'Não Informado',
                        y: {{ $idadeNaoInformado }}
                    }, {
                        x: '39-48',
                        y: {{ $idade39_48 }}
                    }, {
                        x: '29-38',
                        y: {{ $idade29_38 }}
                    }, {
                        x: '18-28',
                        y: {{ $idade18_28 }}
                    }]
                }],

            };

            var options6 = {
                chart: {
                    height: 400,
                    type: 'radialBar',
                },
                series: [{{ $porcentagemDentroDoPrazo }}],
                labels: ['Mês: {{ Carbon\Carbon::now()->format('m/Y') }}'],
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
            <div class="ano">
                <h2>Ano de referencia: {{ Carbon\Carbon::now()->format('Y') }}.</h2>
                <span><strong>Obs.:</strong> os valores são computados mensalmente (dados referentes ao mês {{ Carbon\Carbon::now()->format('m/Y') }}).</span>
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
                        <span>{{ $porcentagemDentroDoPrazo }}%</span>
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
            <span id="grafico-porcentagem">Porcentagem (%)</span>

            <span id="title-idade">Faixa Etária Solicitantes</span>
            <div id="idade"></div>
            <span id="grafico-porcentagem">Porcentagem (%)</span>

            <span id="resposta-porcentagem">Resposta no prazo</span>
            <div id="resposta"></div>

            <div class="text-bottom">
                <p>Dados disponibilizados conforme Lei 13.460 e Lei 12.527.</p>
            </div>

        </section>
    </main>

    @include('components.comp-footer')
@endsection
