@extends('layout.layout-global', ['titulo' => 'Novo Atendimento'])


@push('head')
    <link href="{{ asset('css/pages/page-novo-atendimento.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <script src="{{ asset('js/pages/page-novo-atendimento.js') }}"></script>

@endpush

{{-- @php
    $user = [
        'nome_completo' => 'Louan Bechelli',
    ];
@endphp --}}

@section('conteudo')
    @include('components.comp-header', [
        'usuario' => $user ?? null,
        'banner' => true,
        'titulo_banner' => 'Atendimento',
        'subtitulo_banner' => 'Atendimento ao Cidadão: Ouvidoria',
        'subtitulo_banner_2' => 'Envie sua demanda para a Prefeitura',
    ])
    <main>
        @include('components.comp-sigilo', ['sigilo' => true])

        <section class="container-main-atendimento">
            {{-- <div class="idenficacao">

                <div class="itens ativo">
                    <span><i class="fas fa-info-circle"></i> Informações</span>

                </div>
            </div> --}}
            {{-- <div class="border"><span></span></div> --}}
            <div class="text-sigiloso"><span><strong>Atendimento sigiloso:</strong> Seus dados estarão ocultos durante a tramitação. O pedido de sigilo deve ser justificado e caberá ao destinatário o deferimento ou não do sigilo.</span></div>

            <form class="form new-text" id="new-atendimento-user">
                <div class="cad">
                    <div class="inputs" style="flex-basis: 45%">
                        <label for="assunto">Assunto: *</label>
                        <select id="assunto" name="assunto" required>
                            <option value="" disabled selected>- Selecione -</option>
                            <option value="Esgoto">Esgoto</option>
                            <option value="Limpeza de terreno baldio">Limpeza de terreno baldio</option>
                            <option value="Postos de Saúde">Postos de Saúde</option>
                            <option value="Marcação de consulta/procedimento">Marcação de consulta/procedimento</option>
                            <option value="Fiscalização de Obras">Fiscalização de Obras</option>
                            <option value="Iluminação e Energia">Iluminação e Energia</option>
                            <option value="Criação irregular de animais">Criação irregular de animais</option>
                            <option value="Maus tratos a animais">Maus tratos a animais</option>
                            <option value="Limpeza urbana">Limpeza urbana</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>

                    <div class="inputs outroAssuntoDesejado" style="flex-basis: 40%">
                        <label for="assuntoDesejado">Assunto Desejado *</label>
                        <input type="text" name="assuntoDesejado" id="assuntoDesejado" placeholder="Digite o assunto"/>
                    </div>

                    <div class="inputs">
                        <label for="prioridade">Prioridade: *</label>
                        <select id="prioridade" name="prioridade" style="cursor: pointer" required>
                            <option value="Baixo">Baixo</option>
                            <option value="Media">Média</option>
                            <option value="Alta">Alta</option>
                            <option value="Urgente">Urgente</option>
                        </select>
                    </div>

                    <div class="inputs">
                        <label for="data">Data do ocorrido: *</label>
                        <input type="date" id="data" name="data" required>
                    </div>

                    <div class="inputs">
                        <label for="hora">Hora do ocorrido: *</label>
                        <input type="time" id="hora" name="hora" required>
                    </div>


                    <div class="bloco">
                        <div class="onde">
                            <p>Onde ocorreu? </p>
                        </div>
                        <div class="inputs">
                            <label for="endereco">Endereço completo: *</label>
                            <input type="text" id="endereco" name="endereco" placeholder="Infome o endereço completo" required>
                        </div>

                        <div class="inputs">
                            <label for="referencia">N° ou referência: *</label>
                            <input type="text" id="referencia" name="referencia" placeholder="N°" required>
                        </div>

                        <div class="inputs" style="flex-basis: 100%;">
                            <label for="atendimentoUsuario">Descrição*:</label>
                            <textarea rows="8" cols="50" id="atendimentoUsuario" name="atendimentoUsuario" class="atendimentoUsuario" rows="8" required></textarea>
                        </div>

                    </div>



                    <div class="bloco2">
                        <div class="inputs">
                            <label for="finalidade">Finalidade:</label>
                            <select id="finalidade" name="finalidade" required>
                                <option value="Informação">Informação</option>
                                <option value="Sugestão">Sugestão</option>
                                <option value="Reclamação">Reclamação</option>
                                <option value="Denúncia">Denúncia</option>
                                <option value="Elogio">Elogio</option>
                                <option value="Solicitação">Solicitação</option>
                                <option value="Simplifique">Simplifique</option>
                            </select>
                        </div>

                        <div class="inputs">
                            <label for="codAnterior">Cód. Anteriores: </label>
                            <input type="text" id="codAnterior" name="codAnterior" placeholder="Se este assunto já foi solicitado antes, informe o código" >
                        </div>
                    </div>

                    <div class="bloco3">
                        <input type="file" id="arquivo" name="arquivo">
                        <input type="hidden" name="autor" id="autor" value="Usuario">
                        <input type="hidden" name="id_atendimento" id="id_atendimento" value="{{ $usuario->id }}">
                        <button class="btn-enviar" type="submit">Registrar</button>
                    </div>

                </div>
            </form>
        </section>

    </main>
    @include('components.comp-footer')
@endsection
