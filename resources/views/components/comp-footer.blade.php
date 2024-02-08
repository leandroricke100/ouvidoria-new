@push('head')
    <link href="{{ asset('css/components/comp-footer.css') }}?v={{ time() }}" rel="stylesheet">
@endpush



<footer id="comp-footer">
    <div class="div-footer">
        <img src="{{asset('asset/gw.png')}}" alt="GW">
        <p>Câmara Municipal de Campanário - {{date('Y')}}</p>
    </div>
</footer>
