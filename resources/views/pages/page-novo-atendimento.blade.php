@extends('layout.layout-global', ['titulo' => 'Novo Atendimento'])


@push('head')
    <link href="{{ asset('css/page-novo-atendimento.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <script src="{{ asset('js/page-novo-atendimento.js') }}"></script>
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

    @include('components.comp-sigilo', ['sigilo' => false])

    <section class="container-main-atendimento">
        <div class="text-sigiloso"><span><strong>Atendimento sigiloso:</strong> Seus dados estarão ocultos durante a
                tramitação. O pedido de sigilo
                deve ser justificado e caberá ao destinatário o deferimento ou não do sigilo.</span></div>

        <form class="new-text form" id="new-atendimento-user">
            <div class="cad">
                <div class="inputs" style="flex-basis: 50%">
                    <label for="assunto">Assunto*:</label>
                    <input type="text" id="assunto" name="assunto" placeholder="Assunto" required>
                </div>

                <div class="inputs">
                    <label for="prioridade">Prioridade:</label>
                    <select id="prioridade" name="prioridade">
                        <option value="baixo">Baixo</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>

                <div class="inputs">
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data">
                </div>

                <div class="inputs">
                    <label for="hora">Hora:</label>
                    <input type="number" id="hora" name="hora" placeholder="10:30">
                </div>


                <div class="bloco">
                    <div class="onde">
                        <p>Onde ocorreu? </p>
                    </div>
                    <div class="inputs">
                        <label for="endereco">Endereço completo*:</label>
                        <input type="text" id="endereco" name="endereco" placeholder="Infome o endereço completo">
                    </div>

                    <div class="inputs">
                        <label for="codAnterior">N° ou referência*:</label>
                        <input type="text" id="codAnterior" name="codAnterior"
                            placeholder="Se este assunto já foi solicitado antes, informe os códigos">
                    </div>

                    <div class="inputs" style="flex-basis: 100%;">
                        <label for="atendimentoUsuario">Descrição*:</label>
                        <textarea rows="8" cols="50" id="atendimentoUsuario" name="atendimentoUsuario" class="atendimentoUsuario"
                            rows="8" required></textarea>
                    </div>

                </div>

                <div class="bloco2">
                    <div class="inputs">
                        <label for="finalidade">Finalidade:</label>
                        <select id="finalidade" name="finalidade">
                            <option value="baixo">Informação</option>
                            <option value="media">Sugestão</option>
                            <option value="alta">Reclamação</option>
                            <option value="urgente">Denúncia</option>
                            <option value="urgente">Elogio</option>
                            <option value="urgente">Solicitação</option>
                            <option value="urgente">Simplifique</option>
                        </select>
                    </div>

                    <div class="inputs">
                        <label for="codAnterior">Cód. Anteriores:</label>
                        <input type="text" id="codAnterior" name="codAnterior"
                            placeholder="Se este assunto já foi solicitado antes, informe os códigos">
                    </div>
                </div>

                <div class="bloco3">
                    <input type="file" id="arquivo" name="arquivo">
                    <button class="btn-enviar" type="submit">Registrar</button>
                </div>

            </div>
        </form>
    </section>
    @include('components.comp-footer')
@endsection
