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
                {{-- <h3>Serviços</h3>
            @if (count($menus) === 0)
                <div class="menus">
                    <div class="icons"><span><i class="fas fa-arrow-right"></i></span></div>
                    <div class="opcoes">
                        <h2>Nenhum menu cadastrado</h2>
                    </div>
                </div>
            @else
                @foreach ($menus as $menu)
                    @if ($menu->status == 1)
                        <div class="menus">
                            <div class="icons"><span><i class="fas fa-arrow-right"></i></span></div>
                            <div class="opcoes">
                                <a href="{{ $menu->slog }}">{{ $menu->titulo }}</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif --}}


                {{-- @include('components.comp-login', ['id' => 'login-home']) --}}


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


                <span class="titulo-bx"><i class="fas fa-fw fa-chart-bar"></i> Transparência</span>

                {{-- <div class="menus-right">
                <button><i class="far fa-thumbs-up"></i> <strong>Consulta Prévia Online</strong></button>
            </div> --}}

                <div class="info-prefeitura">
                    <p class="prefeitura">{{ $OuvidoriaConfiguracao->first()->titulo }}</p>
                    <div class="tel-pref">
                        <p>{!! $OuvidoriaConfiguracao->first()->informacoes !!}</p>
                    </div>

                    <button class="organograma">Ver Organograma <i class="fal fa-angle-double-right"></i></button>
                </div>

                {{-- <div class="ajuda">
                <p>Precisa de Ajuda?</p>
                <div class="links-ajuda">
                    <a href="">Como criar um arquivo de projeto/prancha no formato PDF padrão 1Doc</a>
                    <a href="">Utilizando o Login Único gov.br como acesso na Central de Atendimento 1Doc</a>
                    <a href="">Como criar uma solicitação na Central de Atendimento da prefeitura</a>
                    <a href="">Como acompanhar o andamento da sua solicitação</a>
                    <a href="">Como pesquisar documentos, interagir e anexar novas informações.</a>
                    <a href="">Como realizar cadastro na central de atendimento da entidade</a>
                    <a href="">Recuperando seu acesso na central de atendimento da Plataforma 1Doc</a>
                </div>
            </div> --}}
            </div>
        </div>

    </main>

    @include('components.comp-footer')
@endsection
