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
                        <label for="assunto">Assunto*:</label>
                        <select id="assunto" name="assunto" required>
                            <option value="" disabled selected>- Selecione -</option>
                            <option value="Demora no Atendimento">Demora no Atendimento</option>
                            <option value="Meio Ambiente">Meio Ambiente</option>
                            <option value="Reciclagem">Reciclagem</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>

                    <div class="inputs outroAssuntoDesejado" style="flex-basis: 40%">
                        <label for="assuntoDesejado">Assunto Desejado</label>
                        <input type="text" name="assuntoDesejado" id="assuntoDesejado" placeholder="Digite o assuno" />
                    </div>

                    <div class="inputs">
                        <label for="prioridade">Prioridade:</label>
                        <select id="prioridade" name="prioridade" style="cursor: pointer">
                            <option value="Baixo">Baixo</option>
                            <option value="Media">Média</option>
                            <option value="Alta">Alta</option>
                            <option value="Urgente">Urgente</option>
                        </select>
                    </div>

                    <div class="inputs">
                        <label for="data">Data:</label>
                        <input type="date" id="data" name="data">
                    </div>

                    <div class="inputs">
                        <label for="hora">Hora:</label>
                        <input type="time" id="hora" name="hora" placeholder="10:30">
                    </div>


                    <div class="bloco">
                        <div class="onde">
                            <p>Onde ocorreu? </p>
                        </div>
                        <div class="inputs">
                            <label for="endereco">Endereço completo:</label>
                            <input type="text" id="endereco" name="endereco" placeholder="Infome o endereço completo">
                        </div>

                        <div class="inputs">
                            <label for="referencia">N° ou referência:</label>
                            <input type="text" id="referencia" name="referencia" placeholder="N°">
                        </div>

                        <div class="inputs" style="flex-basis: 100%;">
                            <label for="atendimentoUsuario">Descrição*:</label>
                            <textarea rows="8" cols="50" id="atendimentoUsuario" name="atendimentoUsuario" class="atendimentoUsuario" rows="8" required></textarea>
                        </div>

                    </div>

                    <div class="bloco2">
                        <div class="inputs">
                            <label for="finalidade">Finalidade:</label>
                            <select id="finalidade" name="finalidade">
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
                            <label for="codAnterior">Cód. Anteriores:</label>
                            <input type="text" id="codAnterior" name="codAnterior" placeholder="Se este assunto já foi solicitado antes, informe o código">
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
