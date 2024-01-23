@extends('layout.layout-global', ['titulo' => 'Página Login'])

@push('head')
    <link href="{{ asset('css/page-login.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/comp-login.js') }}"></script>
@endpush

@section('conteudo')
    @include('components.comp-header')

    <div class="container-main">
        <h1><i class="fas fa-bullhorn"></i> Atendimentos</h1>
        <p>Atendimento ao Cidadão: Ouvidoria</p>
        <p>Envie sua demanda para a Prefeitura</p>
    </div>

    <div class="container">
        <p>Manifestações anônimas deve ser feitas presencialmente ou pelo telefone 156 de segunda a sexta das 7h às 13h.
        </p>
        <div class="sigilo">
            <p>Identificação:</p>

            <div class="modal-semSigi" style="display: none">
                <p class="text-modal">Seus dados estaram disponivéis durante toda a tramitação de sua solicitação.</p>
            </div>

            <div class="modal-Sigi" style="display: none">
                <p class="text-modal">Seus dados estaram ocultos durante toda a tramitação. O pedido de sigilo deve ser
                    justificado e caberá o destinatáio o cabemento ou não do sigilo.</p>
            </div>

            <div class="input-sigilo">
                <input type="radio" id="semSigilo" name="sigiloso" value="0" checked required>
                <label for="semSigilo" style="margin-bottom: -4px;">
                    Sem sigilo <button onclick="openInfoSigi()" class="semSigi" style="cursor: pointer"><i
                            class="fas fa-question"></i></button>
                </label>

                <input style="margin-left: 15px" type="radio" id="sigilo" name="sigiloso" value="1" required>
                <label for="sigilo" style="margin-bottom: -4px;">Sigiloso <span class="sigi" style="cursor: pointer"><i
                            class="fas fa-question"></i></span></label>
            </div>
        </div>
    </div>

    @include('components.comp-footer')
@endsection
