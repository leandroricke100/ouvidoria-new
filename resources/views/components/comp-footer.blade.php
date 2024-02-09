@inject('OuvidoriaConfiguracao', 'App\Models\OuvidoriaConfiguracao')


@push('head')
    <link href="{{ asset('css/components/comp-footer.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

<footer id="comp-footer">
    <div class="div-footer">
        <img src="{{ asset('asset/gw.png') }}" alt="GW">
        <div class="cliente">
            <p><b>{{ $OuvidoriaConfiguracao->first()->titulo }}</b></p>
            <p>{{ $OuvidoriaConfiguracao->first()->informacoes }}</p>
        </div>

    </div>
</footer>
