@inject('OuvidoriaConfiguracao', 'App\Models\OuvidoriaConfiguracao')

@extends('layout.layout-global', ['titulo' => 'Ouvidoria - ' . $OuvidoriaConfiguracao->first()->titulo])

@push('head')
    <link href="{{ asset('css/pages/page-inicio.css') }}?v={{ time() }}" rel="stylesheet">
@endpush


@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'cadastro' => true,
        'titulo_banner' => 'Central de Atendimento',
        'subtitulo_banner' => $OuvidoriaConfiguracao->first()->titulo,
        'voltar' => false,
    ])

    <main>


        {{-- {!! substr(QrCode::size(90)->generate('https://google.com.br'), 38) !!} --}}

        <section class="banner">

            <div class="banner-opcoes">
                <div class="item">
                    <i class="fal fa-fw fa-thumbs-down"></i>
                    <h3>Reclamação</h3>
                    <p>Relatar insatisfação com ações e serviços prestados</p>
                </div>
                <div class="item">
                    <i class="fal fa-fw fa-comment-alt-lines"></i>
                    <h3>Sugestão</h3>
                    <p>Propor ações úteis para melhoria da gestão</p>
                </div>
                <div class="item">
                    <i class="fal fa-fw fa-thumbs-up"></i>
                    <h3>Elogio</h3>
                    <p>Demonstrar satisfação ou agradecer por algum serviço</p>
                </div>
                <div class="item">
                    <i class="fal fa-fw fa-hand-point-up"></i>
                    <h3>Solicitação</h3>
                    <p>Requerer informações ou esclarecimento de dúvidas</p>
                </div>
                <div class="item">
                    <i class="fal fa-fw fa-megaphone"></i>
                    <h3>Denúncia</h3>
                    <p>Apontar falhas na gestão ou no atendimento recebido</p>
                </div>
                <div class="item">
                    <i class="fal fa-fw fa-check-circle"></i>
                    <h3>Simplifique</h3>
                    <p>Propor simplificações de procedimentos</p>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="container-left">

                <div class="opcoes-home">
                    <span class="titulo-bx"><i class="fas fa-caret-right"></i> Selecione uma opção abaixo</span>
                    <div>
                        <a href="/atendimentos" class="op">
                            <i class="fal fa-file-search"></i>
                            <span>Consultar meus protocolos</span>
                        </a>
                        <a href="/novo/atendimento" class="op">
                            <i class="fal fa-comment-alt-lines"></i>
                            <span>Cadastrar nova solicitação</span>
                        </a>
                    </div>

                </div>

            </div>

            <div class="container-right">

                @php
                    $usuario = session('usuario') ?? null;
                @endphp
                {{-- SE ESTIVER LOGADO --}}
                @if (isset($usuario))
                    @if ($usuario->admin)
                        <div class="inbox">
                            <div class="tel-pref">
                                <p>Olá <b>{{ $usuario->nome_completo }}</b>! Clique abaixo para responder as solicitações.</p>
                            </div>
                            <a href="/atendimentos" class="inbox">Visualizar Solicitações</a>
                        </div>
                    @else
                        <div class="inbox">
                            <div class="tel-pref">
                                <p>Olá,
                                    @if (!$usuario->nome_completo)
                                        {{ explode(' ', $usuario->nome_fantasia)[0] }}
                                    @else
                                        {{ explode(' ', $usuario->nome_completo)[0] }}
                                    @endif. Consulte suas demandas.
                                </p>
                            </div>

                            <a href="/atendimentos" class="inbox">Meu Inbox</a>
                        </div>
                    @endif

                @endif

                <div class="transparencia">
                    <p class="prefeitura"><i class="fas fa-fw fa-chart-bar"></i> Transparência</p>


                    <a href="/transparencia" class="transparencia-btn">Ver Transparencia </a>
                </div>

                <div class="info-prefeitura">
                    <p class="prefeitura">{{ $OuvidoriaConfiguracao->first()->titulo }}</p>
                    <div class="tel-pref">
                        <p>{!! $OuvidoriaConfiguracao->first()->informacoes !!}</p>
                    </div>

                </div>


            </div>
        </div>

    </main>

    @include('components.comp-footer')
@endsection
