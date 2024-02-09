@extends('layout.layout-global', ['titulo' => 'Página Atendimento'])

@push('head')
    <link href="{{ asset('css/pages/page-atendimento.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/pages/page-atendimento.js') }}"></script>
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
@endpush


@section('conteudo')
    @include('components.comp-header', [
        'banner' => true,
        'titulo_banner' => 'Atendimentos',
        'subtitulo_banner' => 'Atendimento ao Cidadão: Ouvidoria',
        'subtitulo_banner_2' => 'Envie sua demanda e acompanhe o andamento',
    ])

    <div class="container-login">

        @include('components.comp-sigilo', ['sigilo' => false])

        <section class="container-atendi">
            <div class="bloco1">
                <div class="image">
                    <img
                         src="data:image/png;base64,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">
                </div>

                <div class="number-atendimento">
                    <div class="bloco-atendimento">
                        <div class="atendimento">
                            <h2><i class="fas fa-bullhorn"></i> <strong>Atendimento</strong></h2>
                            <p>{{ $atendimento->id }}/{{ $atendimento->ano }}</p>
                        </div>
                        <div class="cod">
                            <span>Situação atual: </span>
                            <input type="hidden" name="atendimento_id" id="atendimento_id" value="{{ $atendimento->id }}">
                            @if ($user->admin == 1)
                                <select class="input-situacao" id="situacao" name="situacao">
                                    <option value="Novo" {{ $atendimento->situacao == 'novo' ? 'selected' : '' }}>Novo
                                    </option>
                                    <option value="Andamento" {{ $atendimento->situacao == 'Andamento' ? 'selected' : '' }}>
                                        Andamento</option>
                                    <option value="Finalizado"
                                            {{ $atendimento->situacao == 'Finalizado' ? 'selected' : '' }}>
                                        Finalizado</option>
                                </select>
                            @else
                                <p>{{ $atendimento->situacao }}</p>
                            @endif
                            <span>Código nº:</span>
                            <p>{{ $atendimento->codigo }}</p>
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
                            <input disabled checked class="rating__input rating__input--none" name="rating3"
                                   id="rating3-none" value="0" type="radio">
                            <label aria-label="1 star" class="rating__label" for="rating3-1"><i
                                   class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">
                            <label aria-label="2 stars" class="rating__label" for="rating3-2"><i
                                   class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">
                            <label aria-label="3 stars" class="rating__label" for="rating3-3"><i
                                   class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">
                            <label aria-label="4 stars" class="rating__label" for="rating3-4"><i
                                   class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">
                            <label aria-label="5 stars" class="rating__label" for="rating3-5"><i
                                   class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">
                        </div>
                    </div>

                </div>
            @endif

            <div class="container-atendimento">
                <div class="painel-left">
                    <div class="bloco-sigilo">
                        @if ($atendimento->sigilo == 0)
                            <span>Sigilosa</span>
                        @else
                            <span>Sem Sigilo</span>
                        @endif
                    </div>
                    <div class="finalidade">
                        <p class="fina">{{ $atendimento->tipo }}:</p>
                        <p>Reclamação</p>
                    </div>

                    <div class="border">
                        <span></span>
                    </div>

                    <div class="horario">
                        <span>Em {{ $atendimento->created_at->format('d/m/Y') }} às
                            {{ $atendimento->created_at->format('H:i:s') }}</span>
                        <p>Há {{ $mensagens[0]->tempo_atras }}</p>
                        @if ($atendimento->ref_atendimento)
                            <span>
                                <p>Cód. Anterior: </p>{{ $atendimento->ref_atendimento }}
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
                        <span>{{ $atendimento->situacao }}</span>
                        <h2>{{ $atendimento->assunto }}</h2>
                    </div>
                    <div class="border-2">
                        <span></span>
                    </div>

                    <div class="msg">
                        <div class="data-time">
                            <p><b>Data/Hora:</b> {{ date('d/m/Y H:i:s', strtotime($atendimento->created_at)) }}</p>
                        </div>
                        <p>{{ $mensagens[0]->mensagem }}</p>
                    </div>

                    @if ($mensagens[0]->arquivo)
                        <div class="arquivo">
                            <a class="link" href="/arquivo/{{ $mensagens[0]->arquivo }}" target="blank"><i
                                   class="far fa-paperclip" style="margin-right: 6px"></i>Anexo</a>
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

                                        @if ($mensagem->autor == 'Camara')
                                            @if ($user->admin == 1)
                                                <div id="btn-delete-msg">
                                                    <button id="delete" onclick="deleteMsg({{ $mensagem->id }})"><i
                                                           class="fas fa-trash-alt"></i></button>
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
                                    <p>{{ $mensagem->mensagem }}</p>
                                </div>
                                <div class="border4">
                                    <span></span>
                                </div>

                                @if ($mensagem->arquivo !== null)
                                    <div class="arquivo">
                                        <a class="link" href="/arquivo/{{ $mensagem->arquivo }}" target="blank"><i
                                               class="far fa-paperclip" style="margin-right: 8px"></i>Anexo</a>
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
                <p>Situação atual:</p>
                <span>Em tramitação interna</span>
            </div>

            <div class="border3">
                <span></span>
            </div>

            <div class="new-atendimento">
                @if (isset($user) && $permitir_resposta)
                    <form class="new-text form" id="cad-resposta-user">
                        <label for="atendimentoUsuario"><strong><i class="fas fa-retweet"></i> Interagir em
                                Atendimento</strong></label>
                        <p>Adicione informações e anexe arquivos, caso necessário:</p>
                        <textarea id="atendimentoUsuario" name="atendimentoUsuario" class="atendimentoUsuario" rows="8"></textarea>
                        <input type="file" id="arquivo" name="arquivo">
                        @if ($user->admin == 1)
                            <input type="hidden" name="autor" id="autor" value="Camara">
                            <input type="hidden" name="id_atendimento" id="id_atendimento"
                                   value="{{ $atendimento->id }}">
                        @else
                            <input type="hidden" name="autor" id="autor" value="Usuario">
                            <input type="hidden" name="id_atendimento" id="id_atendimento"
                                   value="{{ $atendimento->id }}">
                        @endif
                        <button id="btn-enviar" type="submit">Enviar</button>
                    </form>
                @endif
            </div>

            <div class="bloco-voltar">
                <a href="/">« Voltar - Central de Atendimento</a>
            </div>

        </section>
    </div>



    @include('components.comp-footer')
@endsection
