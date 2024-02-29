@inject('OuvidoriaConfiguracao', 'App\Models\OuvidoriaConfiguracao')


@push('head')
    <link href="{{ asset('css/components/comp-footer.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

<footer id="comp-footer">
    <div class="div-footer">
        <a href="https://governoweb.com.br/">
            <img src="{{ asset('asset/logo-nova-black.png') }}" alt="logo-governoweb">
        </a>
        <div class="cliente">
            <p><b>{{ $OuvidoriaConfiguracao->first()->titulo }}</b></p>
            <p>{!! $OuvidoriaConfiguracao->first()->informacoes !!}</p>
        </div>

    </div>
</footer>
