@extends('layout.layout-global', ['titulo' => 'Início'])


@push('head')
    <link href="{{ asset('css/page-inicio.css') }}?v={{ time() }}" rel="stylesheet">
@endpush


@section('conteudo')
    @include('components.comp-header')

    <div class="container-main">
        <h1><strong>Central de Atendimento •</strong> Prefeitura de Petrolina</h1>
    </div>
    <div class="container">
        <div class="container-left">
            <h3>Serviços</h3>
            <div class="menus">
                <div class="icons"><span><i class="fas fa-bullhorn"></i></span></div>
                <div class="opcoes">
                    <button>Atendimentos</button>
                    <p>Atendimento ao Cidadão: Ouvidoria Envie sua demanda para a Prefeitura</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-file-alt"></i></span></div>
                <div class="opcoes">
                    <button>Ofícios</button>
                    <p>Consulte a autenticidade e andamento de Ofícios recebidos.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-qrcode"></i></span></div>
                <div class="opcoes">
                    <button>Protocolos</button>
                    <p>Abertura e Consulta de Requerimentos Administrativos.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-keyboard"></i></span></div>
                <div class="opcoes">
                    <button>Chamados</button>
                    <p>Servidor Municipal, abra aqui o seu Chamado para a Informática.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-info"></i></span></div>
                <div class="opcoes">
                    <button>Pedidos de e-SIC</button>
                    <p>Abertura e Consulta.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fas fa-eraser"></i></span></div>
                <div class="opcoes">
                    <button>Viabilização de Construção</button>
                    <p>Abertura e Consulta</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fal fa-file-exclamation"></i></span></div>
                <div class="opcoes">
                    <button>Intimações</button>
                    <p>Consulte a autenticidade de Intimações recebidas.</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="fal fa-list-ol"></i></span></div>
                <div class="opcoes">
                    <button>Processos Seletivos</button>
                    <p>Candidate-se a uma das vagas na Prefeitura de viçosa</p>
                </div>
            </div>

            <div class="menus">
                <div class="icons"><span><i class="far fa-paste"></i></span></div>
                <div class="opcoes">
                    <button>Licenciamento Urbano</button>
                    <p>Aprovação de Projetos e Alvará de Obras, Aprovação de Projetos e Licenciamentos de
                        Loteamentos/Condomínios/Territorial</p>
                </div>
            </div>
        </div>

        <div class="container-right">
            <div class="menus-right">
                <button><i class="fas fa-chart-bar"></i> <strong>Transparência</strong></button>
            </div>

            <div class="menus-right">
                <button><i class="far fa-thumbs-up"></i> <strong>Consulta Prévia Online</strong></button>
            </div>

            <div class="info-prefeitura">
                <p class="prefeitura">Prefeitura de Viçosa</p>
                <div class="tel-pref">
                    <p>R. Gomes Barbosa, 803 - Centro, Viçosa - MG</p>
                    <p><strong>Fone:</strong> (31) 3874-7700</p>
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
