@extends('layout.layout-global', ['titulo' => 'Página Transparência'])

@push('head')
    <link href="{{ asset('css/pages/page-transparencia.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/pages/page-transparencia.js') }}"></script>
@endpush

@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'titulo_banner' => 'Transparência',
    ])
    <main>
        <section>
            <div class="ano">
                <h2>Ano de referencia: 2024</h2>
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
                        <span>100%</span>
                    </div>

                    <div class="qnt-manifestacao">
                        <p>TOTAL SOLICITANTES</p>
                        <span>120</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('components.comp-footer')
@endsection
