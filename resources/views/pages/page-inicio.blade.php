@extends('layout.layout-global', ['titulo' => 'Início'])


@push('head')
    <link href="{{ asset('css/page-inicio.css') }}?v={{ time() }}" rel="stylesheet">
@endpush


@section('conteudo')
    @include(
        'components.comp-header',

        [
            'banner' => true,
            'cadastro' => true,
            'titulo_banner' => 'Central de Atendimento • Prefeitura de Campanário',
        ]
    )
    <div class="container">
        <div class="container-left">
            <h3>Serviços</h3>
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

            {{-- <div class="menus">
                <div class="icons"><span><i class="fas fa-fw fa-file-alt"></i></span></div>
                <div class="opcoes">
                    <a href="/novo/atendimento">Ofícios</a>
                    <p>Consulte a autenticidade e andamento de Ofícios recebidos.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-fw fa-qrcode"></i></span></div>
                <div class="opcoes">
                    <a href="/novo/atendimento">Protocolos</a>
                    <p>Abertura e Consulta de Requerimentos Administrativos.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-fw fa-keyboard"></i></span></div>
                <div class="opcoes">
                    <a href="/novo/atendimento">Chamados</a>
                    <p>Servidor Municipal, abra aqui o seu Chamado para a Informática.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-fw fa-info"></i></span></div>
                <div class="opcoes">
                    <a href="/novo/atendimento">Pedidos de e-SIC</a>
                    <p>Abertura e Consulta.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-fw fa-eraser"></i></span></div>
                <div class="o/novo/atendimentopcoes">
                    <a href="">Viabilização de Construção</a>
                    <p>Abertura e Consulta</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fal fa-fw fa-file-exclamation"></i></span></div>
                <div class="opcoes">
                    <a href="/novo/atendimento">Intimações</a>
                    <p>Consulte a autenticidade de Intimações recebidas.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fal fa-fw fa-list-ol"></i></span></div>
                <div class="opcoes">
                    <a href="/novo/atendimento">Processos Seletivos</a>
                    <p>Candidate-se a uma das vagas na Prefeitura de viçosa</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="far fa-fw fa-paste"></i></span></div>
                <div class="opcoes">
                    <a href="/novo/atendimento">Licenciamento Urbano</a>
                    <p>Aprovação de Projetos e Alvará de Obras, Aprovação de Projetos e Licenciamentos de
                        Loteamentos/Condomínios/Territorial</p>
                </div>
            </div> --}}
        </div>

        <div class="container-right">

            @php
                $usuario = session('usuario') ?? null;
            @endphp
            {{-- SE ESTIVER LOGADO --}}
            @if (isset($usuario))
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


            <div class="menus-right">
                <button><i class="fas fa-fw fa-chart-bar"></i> <strong>Transparência</strong></button>
            </div>

            <div class="menus-right">
                <button><i class="far fa-thumbs-up"></i> <strong>Consulta Prévia Online</strong></button>
            </div>

            <div class="info-prefeitura">
                <p class="prefeitura">Câmara de Campanário</p>
                <div class="tel-pref">
                    <p>R. Antônio Barbosa, 65 - Centro, Campanário - MG</p>
                    <p><strong>Fone:</strong> (33) 3513-1200</p>
                </div>

                <div class="border-bottom"></div>

                <button class="organograma">Ver Organograma <i class="fal fa-angle-double-right"></i></button>
            </div>

            <div class="ajuda">
                <p>Precisa de Ajuda?</p>
                <div class="links-ajuda">
                    <a href="">• Precisa de Ajuda?</a>
                    <a href="">• Como criar um arquivo de projeto/prancha no formato PDF padrão 1Doc</a>
                    <a href="">• Utilizando o Login Único gov.br como acesso na Central de Atendimento 1Doc</a>
                    <a href="">• Como criar uma solicitação na Central de Atendimento da prefeitura</a>
                    <a href="">• Como acompanhar o andamento da sua solicitação</a>
                    <a href="">• Como pesquisar documentos, interagir e anexar novas informações.</a>
                    <a href="">• Como realizar cadastro na central de atendimento da entidade</a>
                    <a href="">• Recuperando seu acesso na central de atendimento da Plataforma 1Doc</a>
                </div>
            </div>
        </div>
    </div>

    @include('components.comp-footer')
@endsection
