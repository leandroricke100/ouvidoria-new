@push('head')
    <link href="{{ asset('css/components/comp-config.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/components/comp-config.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

@endpush



<section class="config-section">


    <div class="bloco">
        <div style="display: none;" id_usuario="{{ $usuario->id }}"></div>

        <button id="btnMinhaConta" onclick="modalConta({{ $usuario->id }})" class="minhaConta" ativo>
            <i class="fas fa-user-cog"></i> Minha Conta
        </button>
        @if ($usuario->admin)
            <button id="btnEndereco" onclick="modalEndereco({{ $usuario->id }})" class="menus">
                <i class="fas fa-map-marker-check"></i> Endereço
            </button>
        @endif


    </div>


    <div class="div-padding">

        <div class="conta" style="{{ $usuario->admin ? 'display: none;' : '' }}">
            <h1>Meus Dados</h1>
            @include('components.comp-cadastro')
        </div>

        <div class="menuEndereco" style="display: none">
            <h1>Informações do Cabeçalho & Rodapé</h1>

            <section class="form-endereco">

                <form class="form" id="endereco-form">
                    <div class="cad-endereco">
                        <div style="display: none;" id_usuario="{{ $usuario->id }}"></div>
                        <div class="field styleMunipio">
                            <label for="nomeMunicipio">Nome do Município</label>
                            <input type="text" id="nomeMunicipio" placeholder="Câmara Municipal XXXX - MG">
                        </div>
                        {{-- <div class="field styleMunipio">
                            <label for="nomeMunicipio">Nome do Município</label>
                            <input type="text" id="nomeMunicipio" placeholder="Câmara Municipal XXXX - MG">
                        </div>

                        <div class="field">
                            <label for="rua">Rua</label>
                            <input type="text" id="rua" placeholder="Rua XXX">
                        </div>

                        <div class="field">
                            <label for="numero">Número</label>
                            <input type="text" id="rua" placeholder="Rua XXX">
                        </div>

                        <div class="field">
                            <label for="complemento">Complemento</label>
                            <input type="text" id="complemento" placeholder="Ex: Complemento">
                        </div>

                        <div class="field">
                            <label for="bairro">Bairro</label>
                            <input type="text" id="bairro" placeholder="Ex: Centro">
                        </div>

                        <div class="field">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado">
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="cep">CEP:</label>
                            <input type="text" dd="cep" name="cep" placeholder="12345-678">
                        </div> --}}

                        <textarea name="enderecoCompleto" id="enderecoCompleto" cols="30" rows="10"></textarea>
                    </div>

                    <div class="button-cad">
                        <button class="button-cad-enviar" type="submit">Prosseguir <i class="fal fa-angle-double-right" style="margin-left: 5px"></i></button>
                        <button class="button-cad-enviar btn-save-cad" type="button" onclick="saveInfo()"><i class="fal fa-save" style="margin-right: 5px"></i> Salvar </button>
                        <button class="button-cad-enviar btn-cancel-cad" type="button" onclick="cancel()"><i class="fal fa-times-circle" style="margin-right: 5px"></i> Cancelar </button>

                    </div>
                </form>

            </section>
        </div>

    </div>

</section>



