@extends('layout.layout-global', ['titulo' => 'Página cadastro'])


@push('head')
    <link href="{{ asset('css/page-cadastro.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
    <script src="{{ asset('js/comp-cadastro.js') }}"></script>
@endpush

@section('conteudo')
    @include('components.comp-header')
    @include('components.comp-sigilo')

    <section class="cad-form-section">
        <form class="form" id="cad-atendimento" onsubmit="return validarSenha()">


            <div class="tipo-cad">
                <div class="radio">
                    <input type="radio" id="pessoaFisica" name="tipoCadastro" value="pessoaFisica" checked required>
                    <label for="pessoaFisica">Pessoa Física</label>
                </div>

                <div class="radio">
                    <input type="radio" id="pessoaJuridica" name="tipoCadastro" value="pessoaJuridica" required>
                    <label for="pessoaJuridica">Pessoa Jurídica</label>
                </div>
            </div>

            {{-- <div class="sigilo">
                <input type="radio" id="semSigilo" name="sigiloso" value="0" checked required>
                <label for="semSigilo" style="margin-bottom: -4px;">
                    Sem sigilo
                </label>

                <input style="margin-left: 15px" type="radio" id="sigilo" name="sigiloso" value="1" required>
                <label for="sigilo" style="margin-bottom: -4px;">Sigiloso</label>
            </div> --}}
            <div class="cadastro cad-borda">
                <div class="field pj">
                    <label for="nomeFantasia">Organização/Nome fantasia*: </label>
                    <input type="text" id="nomeFantasia" name="nomeFantasia" placeholder="Nome" required>
                </div>

                <div class="field pj">
                    <label for="cnpj">CNPJ:</label>
                    <input type="number" id="cnpj" name="cnpj" placeholder="CNPJ">
                </div>

                <div class="field pj">
                    <label for="razaoSocial">Razão Social:</label>
                    <input type="text" id="razaoSocial" name="razaoSocial" placeholder="Razão social">
                </div>

                <div class="field pj">
                    <label for="nomeContato">Nome do contato Principal:</label>
                    <input type="text" id="nomeContato" name="nomeContato" placeholder="Contato">
                </div>

                <div class="pj">
                    <div class="field">
                        <label for="areaAtuacao">Área de atuação:</label>
                        <input type="text" id="areaAtuacao" name="areaAtuacao" placeholder="Área atuacao">
                    </div>
                </div>


                <div class="field pf">
                    <label for="nomeCompleto">Nome completo:<span class="campo-obrigatorio"><span
                                class="campo-obrigatorio">*</span></span></label>
                    <input type="text" id="nomeCompleto" name="nomeCompleto" placeholder="Digite seu nome completo"
                        required>
                </div>


                <div class="field pf">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00">
                </div>


                <div class="field pf">
                    <label for="dataNascimento">Data de Nas:</label>
                    <input type="date" id="dataNascimento" name="dataNascimento">
                </div>

                <div class="field pf">
                    <label for="funcao">Função:</label>
                    <input type="text" id="funcao" name="funcao" placeholder="Função/Cargo">
                </div>

                <div class="field pf">
                    <label for="organizacao">Organização:</label>
                    <input type="text" id="organizacao" name="organizacao" placeholder="Organização">
                </div>

                <div class="field pf">
                    <label for="profissao">Profissão:</label>
                    <input type="text" id="profissao" name="profissao" placeholder="Profissão">
                </div>

                <div class="field pf">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo">
                        <option value="" disabled selected>- Selecione -</option>
                        <option value="solteiro">Masculino</option>
                        <option value="casado">Feminino</option>
                        <option value="naoEspeficicado">Não especificado</option>
                    </select>
                </div>

                <div class="field">
                    <label for="email">E-mail*:</label>
                    <input type="text" id="email" name="email" value='' placeholder="Digite seu e-email"
                        required>
                </div>

                <div class="field">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="Digite seu telefone">
                </div>

                <div class="field">
                    <label for="celular">Celular:</label>
                    <input type="tel" id="celular" name="celular" placeholder="Digite seu celular">
                </div>

                <div class="field">
                    <label for="emailAlternativo">E-mails alternativo (casso possuir):</label>
                    <input type="email" id="emailAlternativo" name="emailAlternativo" placeholder="Caso possuir">
                </div>

            </div>

            <h3 class="endereco">Endereço</h3>

            <div class="cadastro cad-borda">

                <div class="field">
                    <label for="endereco">Endereço completo (com número):</label>
                    <input type="text" id="endereco" name="endereco" placeholder="Digite seu endereço">
                </div>

                <div class="field">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" placeholder="CEP">
                </div>

                <div class="field">
                    <label for="complemento">Complemento:</label>
                    <input type="text" id="complemento" name="complemento" placeholder="Complemento">
                </div>

                <div class="field">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" placeholder="Bairro">
                </div>

                <div class="field">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade" name="cidade" placeholder="Cidade">
                </div>

            </div>

            <h3 class="text-cadastro-log">Cadastre uma senha para fazer Login:</h3>
            <div class="cadastro">

                <div class="field senha">
                    <div class="field">
                        <label for="senha">Senha de acesso:</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                        <p style="display: none" class="msg-senha">Senha</p>
                    </div>

                    <div class="field">
                        <label for="confirmarSenha">Confirmar:</label>
                        <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirmação"
                            required>
                        <p style="display: none" class="msg-senha">Senhas não conferem</p>
                    </div>


                </div>

            </div>
            <div class="min-senha">
                <span>Mínimo: 8 caracteres</span>
            </div>
            <div class="button-cad">
                <button class="button-cad-enviar" type="submit">Prosseguir <i class="fal fa-angle-double-right"
                        style="margin-left: 5px"></i></button>
            </div>
        </form>
    </section>
    </div>
    @include('components.comp-footer')
@endsection
