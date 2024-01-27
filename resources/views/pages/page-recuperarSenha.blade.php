@extends('layout.layout-global', ['titulo' => 'Recuperar Senha'])


@push('head')
    <link href="{{ asset('css/page-recuperarSenha.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('conteudo')
    <div class="background-img">
        <div class="container-password">
            <div class="img-brasao">
                <img src="https://digitaliza-institucional.s3.us-east-2.amazonaws.com/municipio-de-marilac/site/brasao.png"
                    alt="logo da prefeitura" />
            </div>
            <div class="container">
                <label for="recuperarSenha">Recupere sua senha:</label>
                <input type="email" id="recuperarSenha" class="recuperarSenha" placeholder="Endereço de e-mail" required>
                <div class="btn">
                    <button>Recuperar</button>
                    <a href="https://ouvidoria.test/login">« Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
