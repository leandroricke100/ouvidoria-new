@extends('layout.layout-global', ['titulo' => 'Recuperar Senha'])


@push('head')
    <link href="{{ asset('css/pages/page-recuperarSenha.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/pages/page-recuperarSenha.js') }}"></script>
@endpush

@section('conteudo')
    <div class="background-img">
        <div class="container-password">
            <div class="img-brasao">
                <img src="https://digitaliza-institucional.s3.us-east-2.amazonaws.com/municipio-de-campanario/site/brasao.png"
                    alt="logo da prefeitura" />
            </div>
            <div class="container" style="display: block">
                <label for="recuperarSenha">Recupere sua senha:</label>
                <input type="email" id="recuperarSenha" class="recuperarSenha" placeholder="Endereço de e-mail" required>
                <div class="btn">
                    <button onclick="recuperarSenha()">Recuperar</button>
                    <a href="/login">« Voltar</a>
                </div>
            </div>

            <div class="container-nova-password" style="display: none">
                <p class="title-nova-senha">Faça uma nova senha:</p>

                <div class="container-icons">
                    <label for="token">Token</label>
                    <input type="text" id="token" placeholder="Digite o token" required />
                </div>

                <div class="container-icons">
                    <label for="nova-senha">Nova senha</label>
                    <input type="password" id="senha-nova" placeholder="*******" required />
                </div>

                <p style="display: none" class="confirmar-senha">Senhas não conferem</p>

                <div class="container-icons">
                    <label for="confirmar-senha">Confirmar senha</label>
                    <input type="password" id="confirmar-nova-senha" placeholder="*******" required />
                </div>

                <p style="display: none" class="confirmar-senha">Senhas não conferem</p>

                <div class="btn">
                    <button onclick="salvarNovaSenha()">Alterar</button>
                    <a href="/login">« Voltar</a>
                </div>

                <div class="min-senha">
                    <span>Mínimo: 8 caracteres</span>
                    <span>Com caracteres especiais e letra maíuscula.</span>
                </div>

                <div class="mostrar-senha">
                    <input type="checkbox" id="mostarSenha">
                    <p>Mostrar Senha</p>
                </div>
            </div>
        </div>
    </div>
@endsection
