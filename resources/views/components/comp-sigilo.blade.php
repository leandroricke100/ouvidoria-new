@push('head')
    <script src="{{ asset('js/components/comp-sigilo.js') }}"></script>
    <link href="{{ asset('css/components/comp-sigilo.css') }}?v={{ time() }}" rel="stylesheet">
@endpush


@if (isset($sigilo) && $sigilo)
    <section class="container-identificacao">

        <div class="idenficacao">
            <div class="itens">
                <span><i class="fas fa-user"></i>Identificação</span>
                <p>Passo 1</p>
            </div>
            <div class="itens2">
                <span><i class="fas fa-bullhorn"></i>Informações</span>
                <p>Passo 2</p>
            </div>
        </div>
        <div class="container">
            <div class="border"><span></span></div>
            <p>Manifestações anônimas deve ser feitas presencialmente ou pelo telefone 156 de segunda a sexta das 7h às 13h.</p>
            <div class="sigilo">
                <p>Identificação:</p>

                {{-- <div class="modal-semSigi" style="display: none">
                    <p class="text-modal">Seus dados estaram disponivéis durante toda a tramitação de sua solicitação.
                    </p>
                </div> --}}

                {{-- <div class="modal-Sigi" style="display: none">
                    <p class="text-modal">Seus dados estaram ocultos durante toda a tramitação. O pedido de sigilo deve
                        ser justificado e caberá o destinatáio o cabemento ou não do sigilo.</p>
                </div> --}}

                <div class="input-sigilo">
                    <input type="radio" id="semSigilo" name="sigiloso" value="0" checked required>
                    <label for="semSigilo" style="margin-bottom: -4px;">
                        Sem sigilo <button onclick="openInfoSigi()" class="semSigi" style="cursor: pointer"><i class="fas fa-question"></i></button>
                    </label>

                    <input style="margin-left: 15px" type="radio" id="sigilo" name="sigiloso" value="1" required>
                    <label for="sigilo" style="margin-bottom: -4px;">Sigiloso <span class="sigi" style="cursor: pointer"><i class="fas fa-question"></i></span></label>
                </div>
            </div>
        </div>
    </section>
@endif
