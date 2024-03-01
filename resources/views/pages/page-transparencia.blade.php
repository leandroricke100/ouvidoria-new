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
                series: [{{ $porcentagemDentroDoPrazo }}],
                labels: ['Respondidas'],
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
                    data: [{
                        x: 'Outros',
                        y: {{ $porcentagemDentroDoPrazo }}
                    }, {
                        x: 'Limpeza de terreno baldio',
                        y: {{ $quantidade }}
                    }, {
                        x: 'category C',
                        y: {{ $porcentagemDentroDoPrazo }}
                    }]
                }]
            };

            // Renderizar o primeiro gráfico
            var chart1 = new ApexCharts(document.querySelector("#chart"), options1);
            chart1.render();

            // Renderizar o segundo gráfico
            var chart2 = new ApexCharts(document.querySelector("#assunto"), options2);
            chart2.render();
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

            <div id="chart"></div>

            <span id="title-assunto">Principais Assuntos</span>


            <div id="assunto"></div>
            <span id="grafico-porcentagem">Porcentagem (%)</span>


            <div class="text-bottom">
                <p>Dados disponibilizados conforme Lei 13.460 e Lei 12.527.</p>
            </div>

        </section>
    </main>

    @include('components.comp-footer')
@endsection
