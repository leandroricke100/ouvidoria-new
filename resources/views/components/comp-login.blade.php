@push('head')
    <script src="{{ asset('js/components/comp-login.js') }}"></script>
    <link href="{{ asset('css/components/comp-login.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@php
    $id = $id ?? 'pn-login';
@endphp

<section class="login" comp-login="{{$id}}">
    <h3><i class="fas fa-sign-in"></i> Registrar</h3>
    <div class="text-cpf-email">
        <p dd="text-cpf">Insira seu e-mail abaixo</p>
    </div>

    <div class="text-cnpj-email" style="display: none">
        <p dd="text-cnpj">Insira seu CPF ou CNPJ</p>
    </div>

    @if (isset($modalLoginInput) && $modalLoginInput)
        <div class="input-login">
            <input type="email" dd="emailLogin" placeholder="Ex: teste@teste.com" />

            <input type="text" dd="entrarCnpj" placeholder="CPF/CNPJ" style="display: none" />

            {{-- <input type="password" dd="senhaLogin" placeholder="*********" style="display: none" /> --}}

            <div class="container-password" style="display: none">
                <input type="password" dd="senhaLogin" placeholder="*********"  />
                <span class="visualizar-senha" dd="ocultar" onclick="senhaOcultar()" style="display: none"><i class="fas fa-eye-slash"></i></span>
                <span class="visualizar-senha" dd="mostrar" onclick="senhaMostrar()"><i class="fad fa-eye"></i></span>
            </div>

            <button dd="prosseguir" onclick="verificarEmail('{{$id}}')">Prosseguir</button>
            <button dd="entrar" onclick="login('{{$id}}')" style="display: none">Entrar</button>
        </div>
    @else
        <div class="input-login-modal">
            <input type="email" dd="emailLoginModal" placeholder="Ex: teste@teste.com" />
            <div class="container-password">
                <input type="password" dd="senhaLoginModal" placeholder="*********" />
                <span class="visualizar-senha" id="ocultar" onclick="ocultarSenha()" style="display: none"><i class="fas fa-eye-slash"></i></span>
                <span class="visualizar-senha" id="mostrar" onclick="mostrarSenha()"><i class="fad fa-eye"></i></span>
            </div>
            <button onclick="loginModal('{{$id}}')">Entrar</button>
        </div>
    @endif

    <div class="btn-recuperar-senha btn-text-email">
        <button onclick="cnpjCpf()">Sem e-mail? Entre com CPF/CNPJ</button>
        <a href="/novasenha" class="senha">Esqueceu a senha?</a>
        {{-- <button class="senha">Confirmação de segurança*:</button> --}}
    </div>

    <div class="btn-recuperar-senha btn-text-cnpj" style="display: none">
        <button onclick="entrarEmail()">Entre com E-mail</button>
        <a href="/novasenha" class="senha">Esqueceu a senha?</a>
        {{-- <button class="senha">Confirmação de segurança*:</button> --}}
    </div>

    {{-- <div class="login-google">
        <button><i class="fab fa-google-plus-g"></i>Entrar via google</button>
    </div> --}}

    <div class="text-sigilo">
        <i>
            Não postaremos nada nas redes sociais sem sua permissão.
        </i>
    </div>
</section>
