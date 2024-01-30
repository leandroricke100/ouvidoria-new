@push('head')
    <script src="{{ asset('js/comp-login.js') }}"></script>
    <link href="{{ asset('css/comp-login.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

<section class="login">
    <div class="text-cpf-email">
        <p id="text-cpf">Entrar com seu e-mail</p>
    </div>

    <div class="text-cnpj-email" style="display: none">
        <p id="text-cnpj">Entrar com CPF ou CNPJ</p>
    </div>

    @if (isset($modalLoginInput) && $modalLoginInput)
        <div class="input-login">
            <input type="email" id="emailLogin" placeholder="teste@teste.com" />
            <input type="password" id="senhaLogin" placeholder="*********" style="display: none" />
            <button id="prosseguir" onclick="verificarEmail()">Prosseguir</button>
            <button id="entrar" onclick="login()" style="display: none">Entrar</button>
        </div>
    @else
        <div class="input-login-modal">
            <input type="email" id="emailLoginModal" placeholder="teste@teste.com" />
            <input type="password" id="senhaLoginModal" placeholder="*********" />
            <button onclick="loginModal()">Entrar</button>
        </div>
    @endif

    <div class="btn-recuperar-senha btn-text-email">
        <button onclick="cnpjCpf()">Sem e-mail? Entre com CPF/CNPJ</button>
        <a href="/novasenha" class="senha">Esqueceu a senha?</a>
        <a href="/novasenha" class="senha">Não tenho a senha</a>
        <button class="senha">Confirmação de segurança*:</button>
    </div>

    <div class="btn-recuperar-senha btn-text-cnpj" style="display: none">
        <button onclick="entrarEmail()">Entre com E-mail</button>
        <a href="/novasenha" class="senha">Esqueceu a senha?</a>
        <a href="/novasenha" class="senha">Não tenho a senha</a>
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
