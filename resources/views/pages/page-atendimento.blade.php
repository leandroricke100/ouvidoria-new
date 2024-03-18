@extends('layout.layout-global', ['titulo' => 'Página Atendimento'])


@push('head')
    <link href="{{ asset('css/pages/page-atendimento.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <script src="{{ asset('js/pages/page-atendimento.js') }}"></script>
@endpush


@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'titulo_banner' => 'Atendimentos',
        'subtitulo_banner' => 'Atendimento ao Cidadão: Ouvidoria',
        'subtitulo_banner_2' => 'Envie sua demanda e acompanhe o andamento',
    ])


    <main>

        <div class="container-login">

            @include('components.comp-sigilo', ['sigilo' => false])


            <section class="container-atendi">


                <div id="fundo-blur" style="display: none"></div>


                <div class="bloco1">

                    <div class="image">
                        {!! substr(QrCode::size(90)->generate($link), 38) !!}
                    </div>



                    <div class="number-atendimento">
                        <div class="bloco-atendimento">

                            <div id="confirmarExcluir" style="display: none">
                                <h2 class="titleExcluir">Tem certeza que deseja excluir? </h2>
                                <span class="second-title">Não será possível reverter essa ação</span>

                                <div class="btn-confirmar">
                                    <button id="cancelar" onclick="cancelarExcluir()"><i class="fal fa-times-circle"></i> Cancelar</button>
                                    <button id="confirmar" onclick="deleteMsg()"><i class="fas fa-trash-alt"></i> Confirmar</button>
                                </div>

                            </div>
                            @if ($por_codigo)
                                <div id="infoFullUser" style="display: none">
                                    @if ($userReclamante->tipo_pessoa == 'pessoaFisica')
                                        <div class="div-pai" id="conteudoPai" style="display: none">
                                            <div class="close">
                                                <button class="btn-close" onclick="cancelarExcluir()"><i class="fas fa-times"></i> Fechar</button>
                                            </div>
                                            <div class="titleDados">
                                                <h1 style="margin-bottom: 15px "><i class="fad fa-user"></i> Dados do Usuário</h1>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Tipo de Cadastro: </span>
                                                <span>Pessoa Fisíca</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Nome: </span>
                                                <span>{{ $userReclamante->nome_completo }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Sexo: </span>
                                                <span>{{ $userReclamante->sexo }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">CPF: </span>
                                                <span>{{ $userReclamante->cpf }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Data de Nascimento: </span>
                                                <span>{{ date('d/m/Y', strtotime($userReclamante->data_nascimento)) }}
                                                </span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Email: </span>
                                                <span>{{ $userReclamante->email }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Email Alternativo: </span>
                                                @if ($userReclamante->email_alternativo)
                                                    <span>{{ $userReclamante->email_alternativo }}</span>
                                                @else
                                                    <span>Não Informado</span>
                                                @endif
                                            </div>


                                            <div class="conteudoInfo">
                                                <span class="title-info">Telefone: </span>
                                                @if ($userReclamante->email_alternativo)
                                                    <span>{{ $userReclamante->telefone }}</span>
                                                @else
                                                    <span>Não Informado</span>
                                                @endif
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Celular: </span>
                                                <span>{{ $userReclamante->celular }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Endereço do Usuário: </span>
                                                <span><strong>Rua/N°: </strong>{{ $userReclamante->endereco }}</span>
                                                <span><strong>Bairro: </strong>{{ $userReclamante->bairro }}</span>
                                                <span><strong>Cidade: </strong>{{ $userReclamante->cidade }}</span>
                                                <span><strong>CEP: </strong>{{ $userReclamante->cep }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Organização: </span>
                                                <span>{{ $userReclamante->organizacao }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Profissão: </span>
                                                <span>{{ $userReclamante->profissao }}</span>
                                            </div>

                                        </div>
                                    @else
                                        <div class="div-pai" id="conteudoPai" style="display: none">
                                            <div class="close">
                                                <button class="btn-close" onclick="cancelarExcluir()"><i class="fas fa-times"></i> Fechar</button>
                                            </div>
                                            <div class="titleDados">
                                                <h1 style="margin-bottom: 15px "><i class="fad fa-building"></i> Dados do Usuário</h1>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Tipo de Cadastro: </span>
                                                <span>Pessoa Jurídica</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Nome do Responsável: </span>
                                                <span>{{ $userReclamante->nome_responsavel }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Razão Social: </span>
                                                <span>{{ $userReclamante->razao_social }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Nome Fantasia: </span>
                                                <span>{{ $userReclamante->nome_fantasia }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">CNPJ: </span>
                                                <span>{{ $userReclamante->cnpj }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Área de Atuação: </span>
                                                <span>{{ $userReclamante->area_atuacao }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Email: </span>
                                                <span>{{ $userReclamante->email }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Email Alternativo: </span>
                                                <span>{{ $userReclamante->email_alternativo }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Telefone: </span>
                                                @if ($userReclamante->telefone)
                                                    <span>{{ $userReclamante->telefone }}</span>
                                                @else
                                                    <span>Não Informado</span>
                                                @endif
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Celular: </span>
                                                <span>{{ $userReclamante->celular }}</span>
                                            </div>

                                            <div class="conteudoInfo">
                                                <span class="title-info">Endereço do Usuário: </span>
                                                <span><strong>Rua/N°: </strong>{{ $userReclamante->endereco }}</span>
                                                <span><strong>Bairro: </strong>{{ $userReclamante->bairro }}</span>
                                                <span><strong>Cidade: </strong>{{ $userReclamante->cidade }}</span>
                                                <span><strong>CEP: </strong>{{ $userReclamante->cep }}</span>
                                            </div>

                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="atendimento">
                                <h2><i class="fas fa-bullhorn"></i> <strong>Atendimento</strong></h2>
                                <p>{{ $atendimento->id }}/{{ $atendimento->ano }}</p>
                            </div>
                            <div class="cod">
                                <div class="cod-mobile">
                                    <span><strong>Situação atual: </strong></span>
                                    <input type="hidden" name="atendimento_id" id="atendimento_id" value="{{ $atendimento->id }}">
                                    @if ($primeiraRespostaCamara)
                                        @if ($user && $user->admin == 1)
                                            <select class="input-situacao" id="situacao" name="situacao">
                                                <option value="Novo" {{ $atendimento->situacao == 'novo' ? 'selected' : '' }}>Novo
                                                </option>
                                                <option value="Andamento" {{ $atendimento->situacao == 'Andamento' ? 'selected' : '' }}>
                                                    Andamento</option>
                                                <option value="Finalizado" {{ $atendimento->situacao == 'Finalizado' ? 'selected' : '' }}>
                                                    Finalizado</option>
                                            </select>
                                        @else
                                            <p>{{ $atendimento->situacao }}</p>
                                        @endif
                                    @else
                                        @if ($user && $user->admin == 1)
                                            <select class="input-situacao" id="situacao" name="situacao">
                                                <option value="Novo" {{ $atendimento->situacao == 'novo' ? 'selected' : '' }}>Novo
                                                </option>
                                            </select>
                                        @else
                                            <p>{{ $atendimento->situacao }}</p>
                                        @endif
                                    @endif
                                </div>
                                <div class="cod-mobile bloco2">
                                    <span><strong>Código nº:</strong></span>
                                    <p>{{ $atendimento->codigo }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="div-print">
                            <button onclick="printPage()" class="print"><i class="fas fa-print"></i> Imprimir</button>
                        </div>
                    </div>
                </div>


                {{-- SE ATENDIMENTO ESTIVER FINALIZADO MOSTRAR CONTAINER AVALIAÇÃO --}}
                @if ($atendimento->situacao == 'Finalizado')
                    <div class="container-avalicao">

                        <div class="avalicao">
                            <p>AVALIE ATENDIMENTO</p>
                            <p class="pesquisa">Pesquisa de Satisfação</p>
                        </div>


                        <div id="full-stars-example-two">
                            <div class="rating-group">
                                {{-- <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="{{ $avaliacao }}" type="radio"> --}}
                                <label aria-label="1 star" class="rating__label" for="rating3-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio" @if ($avaliacao == 1) checked @endif>
                                <label aria-label="2 stars" class="rating__label" for="rating3-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio" @if ($avaliacao == 2) checked @endif>
                                <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio" @if ($avaliacao == 3) checked @endif>
                                <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio" @if ($avaliacao == 4) checked @endif>
                                <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio" @if ($avaliacao == 5) checked @endif>
                                <input type="hidden" name="id_atendimento" id="id_atendimento" value="{{ $atendimento->id }}">
                                <input type="hidden" name="permitido" id="permitido" value="{{ $permitir_resposta }}">
                            </div>
                        </div>

                    </div>
                @endif

                <div class="container-atendimento">
                    <div class="painel-left">
                        <div class="bloco-sigilo">
                            @if ($atendimento->sigiloso == 1)
                                <span>Sigilosa</span>
                            @else
                                <span>Sem Sigilo</span>
                            @endif
                        </div>
                        <div class="finalidade">
                            <p><strong>Finalidade: </strong></p>
                            <p class="fina">{{ $atendimento->tipo }}</p>
                        </div>

                        <div class="horario">
                            <span><strong>Criado em: </strong><br>{{ date('d/m/Y', strtotime($atendimento->created_at)) }} às
                                {{ $atendimento->created_at->format('H:i:s') }}</span>
                            <p>Há {{ $mensagens[0]->tempo_atras }}</p>
                        </div>

                        <div class="border">
                            <span></span>
                        </div>

                        <div class="horario">
                            <span><strong>Ocôrrido em: </strong><br>{{ date('d/m/y', strtotime($atendimento->data)) }} às
                                {{ $atendimento->hora }}</span>
                            @if ($por_codigo)
                                @if ($atendimento->sigiloso == 0)
                                    <div class="dadosUser">
                                        <div class="nameUser">
                                            <strong>Reclamante:</strong>
                                            @if ($userReclamante->tipo_pessoa == 'pessoaFisica')
                                                <p>{{ $userReclamante->nome_completo }}</p>
                                            @else
                                                <p>{{ $userReclamante->nome_responsavel }}</p>
                                            @endif

                                        </div>

                                        <div class="cpfCnpj">
                                            <strong>CPF/CNPJ:</strong>
                                            @if ($userReclamante->tipo_pessoa == 'pessoaFisica')
                                                <p>{{ $userReclamante->cpf }}</p>
                                            @else
                                                <p>{{ $userReclamante->cnpj }}</p>
                                            @endif

                                        </div>

                                        @if ($user->admin == 1)
                                            <button class="informacao" onclick="infoReclamente()">
                                                <i class="fas fa-info-circle" style="margin-right: 5px"></i> Informações do Reclamante
                                            </button>
                                        @endif


                                    </div>
                                @endif
                            @endif



                            @if ($atendimento->ref_atendimento)
                                <span class="cod-anterior">
                                    <p>Cód. Atendimento anterior: </p>{{ $AtendimentoAnterior }}
                                </span>
                            @endif
                        </div>



                        @if ($atendimento->endereco)
                            <div class="border">
                                <span></span>
                            </div>
                            <div class="local">
                                <span>
                                    <strong>Localização:</strong> {{ $atendimento->endereco }}, Nº
                                    {{ $atendimento->numero_referencia }}.
                                </span>
                            </div>
                        @endif

                    </div>
                    <div class="painel-right">
                        <div class="title">
                            <div class="bloco-title">
                                <span>{{ $atendimento->situacao }}</span>
                                <h2>{{ $atendimento->assunto }}</h2>
                            </div>

                            <div class="data-time">
                                <p><strong>Data/Hora:</strong></p>
                                <p>{{ date('d/m/Y H:i:s', strtotime($atendimento->created_at)) }}</p>
                            </div>
                        </div>



                        <div class="border-2">
                            <span></span>
                        </div>

                        <div class="msg">

                            <p>{{ $mensagens[0]->mensagem }}</p>
                        </div>

                        @if ($mensagens[0]->arquivo)
                            <div class="arquivo">
                                <a class="link" href="/arquivo/{{ $mensagens[0]->arquivo }}" target="blank">
                                    <i class="far fa-paperclip" style="margin-right: 6px"></i>Anexo</a>
                            </div>
                        @else
                            <div class="arquivo">
                                <span>Sem Anexo</span>
                        @endif
                    </div>
                </div>
            </section>

            <section class="container-atendi">
                <div class="comentario">
                    @foreach ($mensagens as $mensagem)
                        @if (!$loop->first)
                            <div class="bloco">
                                <div class="bloco-left">
                                    <div>
                                        <div class="number-despacho">

                                            <div class="despacho">
                                                <p>Despacho</p>
                                                <p>{{ $mensagem->id }}/{{ $atendimento->ano }}</p>
                                            </div>

                                            @if ($user && $user->admin == 1)
                                                @if ($mensagem->autor == 'Camara')
                                                    <div id="btn-delete-msg">
                                                        <button id="delete" onclick="confirmarExcluir({{ $mensagem->id }})"><i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                @endif
                                            @endif

                                        </div>
                                        <div class="tempo-res">
                                            <p>{{ $mensagem->created_at->format('d/m/Y') }} às
                                                {{ $mensagem->created_at->format('H:i:s') }}</p>
                                        </div>
                                    </div>
                                    <div class="titular">
                                        @if ($mensagem->autor == 'Camara')
                                            <span><i class="fas fa-university"></i>{{ $mensagem->autor }}</span>
                                        @else
                                            <span><i class="fas fa-user"></i>{{ $mensagem->autor }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="bloco-right">
                                    <div class="res-comentario">
                                        <p>{!! $mensagem->mensagem !!}</p>
                                    </div>
                                    <div class="border4">
                                        <span></span>
                                    </div>

                                    @if ($mensagem->arquivo)
                                        <div class="arquivo">
                                            <a class="link" href="/arquivo/{{ $mensagem->arquivo }}" target="blank"><i class="far fa-paperclip" style="margin-right: 8px"></i>Anexo</a>
                                        </div>
                                    @else
                                        <div class="arquivo">
                                            <span>Sem Anexo</span>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endif
                    @endforeach
                </div>


                <div class="border3">
                    <span></span>
                </div>

                <div class="situacao-atual">
                    <p><strong>Situação atual:</strong></p>
                    @if ($atendimento->situacao == 'Finalizado')
                        <div class="novoChamado">
                            <span>Encerrado</span>
                            <span class="novo">Abrir um novo atendimento com Referência a esse atendimento? <a class="btn-novoAtendimento" href="{{ route('rotadenovoatendimento', ['codigo_ref' => $atendimento->codigo]) }}">Novo</a>
                            </span>
                        </div>
                    @else
                        <span>Em tramitação interna</span>
                    @endif

                </div>

                <div class="border3">
                    <span></span>
                </div>


                <div class="new-atendimento">
                    @if ($atendimento->situacao == 'Finalizado')
                    @else
                        @if (isset($user) && $permitir_resposta)
                            <form class="new-text form" id="cad-resposta-user">
                                <label for="atendimentoUsuario"><strong><i class="fas fa-retweet"></i> Interagir em Atendimento</strong></label>
                                <p>Adicione informações e anexe arquivos, caso necessário:</p>
                                <textarea id="atendimentoUsuario" name="atendimentoUsuario" class="atendimentoUsuario" rows="8"></textarea>
                                <input type="file" id="arquivo" name="arquivo">
                                @if ($user->admin == 1)
                                    <input type="hidden" name="autor" id="autor" value="Camara">
                                    <input type="hidden" name="id_atendimento" id="id_atendimento" value="{{ $atendimento->id }}">
                                @else
                                    <input type="hidden" name="autor" id="autor" value="Usuario">
                                    <input type="hidden" name="id_atendimento" id="id_atendimento" value="{{ $atendimento->id }}">
                                @endif
                                <button id="btn-enviar" type="button" onclick="submitResposta();">Enviar</button>
                            </form>
                        @endif
                    @endif
                </div>




                <div class="bloco-voltar">
                    <a href="/">« Voltar - Central de Atendimento</a>
                </div>

            </section>
        </div>
    </main>

    @include('components.comp-footer')
@endsection
