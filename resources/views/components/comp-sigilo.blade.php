@push('head')
    <script src="{{ asset('js/components/comp-sigilo.js') }}"></script>
    <link href="{{ asset('css/components/comp-sigilo.css') }}?v={{ time() }}" rel="stylesheet">
@endpush


@if (isset($sigilo) && $sigilo)
    <div class="padding-mobile">
        <section class="container-identificacao">

            <div class="idenficacao">
                <button id="itens" class="itens ativo"><i class="fas fa-user"></i>Identificação</button>
                {{-- <button class="itens"><i class="fas fa-bullhorn"></i>Informações <p>Passo 2</p></button> --}}
            </div>
            <div class="container">
                {{-- <div class="border"><span></span></div> --}}
                <p>Manifestações anônimas deve ser feitas presencialmente ou pelo telefone 156 de segunda a sexta das 7h às 13h.</p>
                <div class="sigilo">
                    <p>Identificação:</p>

                    {{-- <div class="modal-semSigi" style="display: none">
                        <p class="text-modal">Seus dados estaram disponivéis durante toda a tramitação de sua solicitação.
                        </p>
                    </div> --}}

                    {{-- <div class="modal-Sigi" style="display: none">
                        <p class="text-modal">Seus dados estaram ocultos durante toda a tramitação. O pedido de sigilo deve
                            ser
                            justificado e caberá o destinatáio o cabemento ou não do sigilo.</p>
                    </div> --}}

                    <div class="input-sigilo">
                        <input type="radio" id="semSigilo" name="sigiloso" value="0" checked required>
                        <label for="semSigilo" style="margin-bottom: -4px;">
                            Sem sigilo <span onclick="openInfoSigi()" class="semSigi"><i class="fas fa-question-circle"></i></span>
                        </label>

                        <input style="margin-left: 15px" type="radio" id="sigilo" name="sigiloso" value="1" required>
                        <label for="sigilo" style="margin-bottom: -4px;">
                            Sigiloso <span class="sigi"><i class="fas fa-question-circle"></i></span>
                        </label>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endif
