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
                            <li><a data-toggle="modal" data-target="#nuovo-articolo-modal">Articolo</a></li>
                        </ul>
                    </div>
                </li>
                @endif
                <li>
                    <a href="/cliente/1">Clienti</a>
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
