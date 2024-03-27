

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
                        <div class="img">
                            <p class="title-brasao">Foto do Brasão</p>
                            <div class="imgFile">
                                <label for="arquivo">Selecionar um arquivo</label>
                                <input type="file" id="arquivo" name="arquivo" value="" >
                                <span id="file-name">Nenhum arquivo selecionado</span>
                            </div>
                        </div>

                        <div class="field styleMunipio">
                            <label for="nomeMunicipio">Nome do Município</label>
                            <input type="text" id="nomeMunicipio" placeholder="Câmara Municipal XXXX - MG">
                        </div>


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
