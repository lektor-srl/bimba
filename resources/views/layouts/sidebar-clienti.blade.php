@section('sidebar-clienti')
    <div class="uk-width-1-4@m text-dark sidebar">
        <h3 style="margin-bottom: 30px">Clienti</h3>
        <ul class="uk-list uk-list-large uk-margin-medium-bottom">
            @foreach($clienti as $cliente)
                <li><a href="/cliente/{{ $cliente['id'] }}">{{ ucfirst($cliente['nome']) }}<span style="float: right">{{ $cliente['numProgetti'] }}</span></a></li>
            @endforeach

        </ul>
    </div>
@endsection
