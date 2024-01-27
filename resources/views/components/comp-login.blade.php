@push('head')
    <link href="{{ asset('css/comp-login.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

<section class="login">
    <div class="text-cpf-email">
        <p>Entrar com seu e-mail</p>
        <p style="display: none">Entrar com CPF ou CNPJ</p>
    </div>

    <div class="input-login">
        <input type="email" id="emailLogin" placeholder="teste@teste.com" />
        <button>Prosseguir</button>
    </div>

    <div class="btn-recuperar-senha">
        <button>Sem e-mail? Entre com CPF/CNPJ</button>
        <a href="https://ouvidoria.test/novasenha" class="senha">Esqueceu a senha?</a>
        <a href="https://ouvidoria.test/novasenha" class="senha">Não tenho a senha</a>
        <button class="senha">Confirmação de segurança*:</button>
    </div>

    <div class="login-google">
        <button><i class="fab fa-google-plus-g"></i>Entrar via google</button>
    </div>

    <div class="text-sigilo">
        <i>
            <p>Não postaremos nada nas redes sociais</p>
        </i>
        <i>
            <p>sem sua permissão.</p>
        </i>
    </div>
</section>
