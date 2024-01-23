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
                <button><i class="fas fa-bullhorn"></i> Atendimentos</button>
                <p>Atendimento ao Cidadão: Ouvidoria
                    Envie sua demanda para a Prefeitura</p>
            </div>

            <div class="menus">
                <button><i class="fas fa-file-alt"></i> Ofícios</button>
                <p>Consulte a autenticidade e andamento
                    de Ofícios recebidos.</p>
            </div>

            <div class="menus">
                <button><i class="fas fa-qrcode"></i> Protocolos</button>
                <p>Abertura e Consulta
                    de Requerimentos Administrativos.</p>
            </div>

            <div class="menus">
                <button><i class="fas fa-keyboard"></i> Chamados</button>
                <p>Servidor Municipal, abra aqui
                    o seu Chamado para a Informática.</p>
            </div>

            <div class="menus">
                <button><i class="fas fa-info"></i> Pedidos de e-SIC</button>
                <p>Abertura e Consulta.</p>
            </div>

            <div class="menus">
                <button><i class="fas fa-eraser"></i> Viabilização de Construção</button>
                <p>Abertura e Consulta</p>
            </div>

            <div class="menus">
                <button><i class="fal fa-file-exclamation"></i> Intimações</button>
                <p>Consulte a autenticidade
                    de Intimações recebidas.</p>
            </div>

            <div class="menus">
                <button><i class="fal fa-list-ol"></i> Processos Seletivos</button>
                <p>Candidate-se a uma das vagas na Prefeitura de viçosa</p>
            </div>

            <div class="menus">
                <button><i class="far fa-paste"></i> Licenciamento Urbano</button>
                <p>Aprovação de Projetos e Alvará de Obras, Aprovação de Projetos e Licenciamentos de
                    Loteamentos/Condomínios/Territorial</p>
            </div>
        </div>

        <div class="container-right">
            <div menus-right>
                <button><i class="fas fa-chart-bar"></i> Transparência</button>
            </div>

            <div menus-right>
                <button><i class="far fa-thumbs-up"></i> Consulta Prévia Online</button>
            </div>

            <div class="info-prefeitura">
                <h2>Prefeitura de Viçosa</h2>
                <p>R. Gomes Barbosa, 803 - Centro, Viçosa - MG</p>
                <p><strong>Fone:</strong> (31) 3874-7700</p>

                <button class="organograma">Ver Organograma <i class="fal fa-angle-double-right"></i></button>
            </div>

            <div class="ajuda">
                <p>Precisa de Ajuda?</p>
                <div>
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
