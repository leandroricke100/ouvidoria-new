@push('head')
    <link href="{{ asset('css/components/comp-cadastro.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <script src="{{ asset('js/tools/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/components/comp-cadastro.js') }}"></script>
@endpush

@php
    $usuario = session('usuario') ?? null;
@endphp

<div class="padding-mobile">
    <section class="cad-form-section">
        <form class="form" id="cad-atendimento">

            <input type="hidden" name="id_usuario" value="{{ $usuario ? $usuario->id : '' }}">

            <div class="tipo-cad">
                <div class="radio">
                    <input type="radio" id="pessoaFisica" name="tipoCadastro" value="pessoaFisica" checked required>
                    <label for="pessoaFisica"> Pessoa Física <i class="fas fa-users" style="margin-left: 5px"></i></label>
                </div>

                <div class="radio">
                    <input type="radio" id="pessoaJuridica" name="tipoCadastro" value="pessoaJuridica" required>
                    <label for="pessoaJuridica"> Pessoa Jurídica <i class="fas fa-building" style="margin-left: 5px"></i></label>
                </div>
            </div>


            <div class="cadastro cad-borda">
                <div class="field pj" style="flex-basis: 60%">
                    <label for="nomeFantasia">Organização/Nome fantasia: *</label>
                    <input type="text" id="nomeFantasia" name="nomeFantasia" placeholder="Nome" required>
                </div>

                <div class="field pj" style="flex-basis: 30%">
                    <label for="cnpj">CNPJ: *</label>
                    <input type="text" id="cnpj" name="cnpj" placeholder="CNPJ" required>
                </div>

                <div class="field pj" style="flex-basis: 30%">
                    <label for="razaoSocial">Razão Social: *</label>
                    <input type="text" id="razaoSocial" name="razaoSocial" placeholder="Razão social" required>
                </div>

                <div class="field pj" style="flex-basis: 30%">
                    <label for="nomeContato">Nome do contato Principal: *</label>
                    <input type="text" id="nomeContato" name="nomeContato" placeholder="Contato" required>
                </div>


                <div class="field pj" style="flex-basis: 30%">
                    <label for="areaAtuacao">Área de atuação: *</label>
                    <input type="text" id="areaAtuacao" name="areaAtuacao" placeholder="Área de atuação" required>
                </div>



                <div class="field pf" style="flex-basis: 42%">
                    <label for="nomeCompleto">Nome completo: *</label>
                    <input type="text" id="nomeCompleto" name="nomeCompleto" placeholder="Nome completo" required>
                </div>


                <div class="field pf" style="flex-basis: 30%">
                    <label for="cpf">CPF: *</label>
                    <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                </div>


                <div class="field pf">
                    <label for="dataNascimento">Data de Nas: *</label>
                    <input type="date" id="dataNascimento" name="dataNascimento" required>
                </div>


                <div class="field pf" style="flex-basis: 45%">
                    <label for="organizacao">Organização: *</label>
                    <input type="text" id="organizacao" name="organizacao" placeholder="Organização" required>
                </div>



                <div class="field pf" style="flex-basis: 50%" >
                    <label  for="profissao">Profissão: *</label>
                    <input type="text" id="profissao" name="profissao" placeholder="Digite a Profissão" required>
                </div>


                <div class="field pf" style="flex-basis: 45%">
                    <label for="sexo">Sexo: *</label>
                    <select id="sexo" name="sexo" required>
                        <option value="" disabled selected>- Selecione -</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                        <option value="NaoEspeficicado">Não especificado</option>
                    </select>
                </div>

                <div class="field" style="flex-basis: 50%">
                    <label for="email">E-mail: *</label>
                    <input type="text" id="email" name="email" value='' placeholder="Digite seu e-email" required>
                </div>

                <div class="field" style="flex-basis: 45%">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="Digite seu telefone">
                </div>

                <div class="field" style="flex-basis: 50%">
                    <label for="celular">Celular: *</label>
                    <input type="tel" id="celular" name="celular" placeholder="Digite seu celular" required>
                </div>

                <div class="field" style="flex-basis: 100%">
                    <label for="emailAlternativo">E-mails alternativo (casso possuir):</label>
                    <input type="email" id="emailAlternativo" name="emailAlternativo" placeholder="Caso possuir">
                </div>

            </div>

            <p class="endereco">Endereço</p>

            <div class="cadastro cad-borda">

                <div class="field" style="flex-basis: 64%">
                    <label for="endereco">Endereço completo (com número): *</label>
                    <input type="text" id="endereco" name="endereco" placeholder="Digite seu endereço">
                </div>

                <div class="field" style="flex-basis: 30%">
                    <label for="cep">CEP: </label>
                    <input type="text" id="cep" name="cep" placeholder="CEP">
                </div>

                <div class="field">
                    <label for="complemento">Complemento:</label>
                    <input type="text" id="complemento" name="complemento" placeholder="Complemento">
                </div>

                <div class="field">
                    <label for="bairro">Bairro: *</label>
                    <input type="text" id="bairro" name="bairro" placeholder="Bairro">
                </div>

                <div class="field">
                    <label for="cidade">Cidade: *</label>
                    <input type="text" id="cidade" name="cidade" placeholder="Cidade">
                </div>

            </div>

            <h3 class="text-cadastro-log">Cadastre uma senha para fazer Login:</h3>
            <div class="cadastro">

                <div class="field senha">
                    <div class="field">
                        <label for="senha">Senha de acesso: *</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                        <p style="display: none" class="msg-senha">Senhas não conferem</p>
                    </div>

                    <div class="field">
                        <label for="confirmarSenha">Confirmar: *</label>
                        <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirmação" required>
                        <p style="display: none" class="msg-senha">Senhas não conferem</p>
                    </div>


                </div>

            </div>
            <div class="min-senha">
                <span>Mínimo: 8 caracteres</span>
                <span>Com caracteres especiais e letra maíuscula.</span>
            </div>

            <div class="mostrar-senha">
                <input type="checkbox" id="mostarSenha">
                <p>Mostrar Senha</p>
            </div>

            <div class="button-cad">
                <button class="button-cad-enviar" type="submit">Prosseguir <i class="fal fa-angle-double-right" style="margin-left: 5px"></i></button>
                <button class="button-cad-enviar btn-save-cad" type="button" onclick="saveCadastro()" style="display: none"><i class="fal fa-save" style="margin-right: 5px"></i> Salvar</button>
            </div>
        </form>
    </section>

</div>
