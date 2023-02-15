<div class="uk-container">
    <div uk-navbar="">
        <div class="uk-navbar-left">
            <a class="uk-navbar-item uk-logo" href="/" style="font-size: 25px">
                <img src="https://www.lektorweb.eu/wp-content/uploads/2020/06/lektor-bianco.png" width="150px">
            </a>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav uk-text-uppercase uk-visible@m uk-margin-medium-left">
                @if( Auth::user()->ruolo->write)
                <li>
                    <a href="#">Nuovo</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li><a data-toggle="modal" data-target="#nuovo-cliente-modal">Cliente</a></li>
                            <li><a data-toggle="modal" data-target="#nuovo-progetto-modal">Progetto</a></li>
                        </ul>
                    </div>
                </li>
                @endif
                <li>
                    <a href="#">Clienti</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            @foreach($clienti as $cliente)
                                <li><a href="/cliente/{{ $cliente['id'] }}">{{ $cliente['nome'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#">Progetti</a>
                    <div style="min-width: 400px"class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            @foreach($progetti as $progetti)
                                <li><a href="/articolo/view/{{ $progetti['id'] }}">{{ $progetti['titolo'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>

                <li>
                    <a>{{ Auth::user()->name }}</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li><a href="#">Gestione profilo</a></li>
                            <li><a href="/logout">Logout</a></li>
                            @if(Auth::user()->ruolo->system)
                            <li><a href="/ruoli">Gestione ruoli</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
            </ul>
            <a class="uk-navbar-toggle uk-hidden@m" href="#offcanvas" uk-navbar-toggle-icon="" uk-toggle=""></a>
        </div>
    </div>
</div>
