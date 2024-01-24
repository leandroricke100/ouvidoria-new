@extends('layout.layout-global', ['titulo' => 'Página Login'])

@push('head')
    <link href="{{ asset('css/page-login.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.min.js') }}"></script>
@endpush

@section('conteudo')
    @include('components.comp-header')

    <div class="container-login">

        @include('components.comp-sigilo')

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
                <button>Esqueceu a senha?</button>
            </div>

            <div class="login-google">
                <button><i class="fab fa-google-plus-g"></i>Entrar via google</button>
            </div>

            <div class="text-sigilo">
                <p>Não postaremos nada nas redes sociais</p>
                <p>sem sua permissão.</p>
            </div>
        </section>

    </div>
    @include('components.comp-footer')
@endsection
