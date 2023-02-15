<!DOCTYPE html>
<html lang="it-it">

<head>
    @include('layouts.head')
    @yield('head')
</head>

<body>
<!-- Nuovo cliente modale -->
<x-nuovo-cliente-modal></x-nuovo-cliente-modal>

<!-- Nuovo progetto modale -->
<x-nuovo-progetto-modal></x-nuovo-progetto-modal>


<div class="section-hero uk-background-blend-color-burn uk-background-top-center uk-background-cover uk-section-large1 cta" style="background-image: url(https://www.lektorweb.eu/wp-content/uploads/2020/01/iu.jpeg); background-position: center top">
    <nav class="uk-navbar-container uk-margin uk-navbar-transparent uk-light">
        <x-topbar></x-topbar>
    </nav>

    <div class="uk-container hero">
        <h1 class="uk-heading-primary uk-text-center uk-margin-large-top uk-light">BimBa</h1>
        <p class="uk-text-lead uk-text-center uk-light">La documentazione ufficiale di Lektor S.r.l.</p>
        <div class="uk-flex uk-flex-center">
            <form class="uk-margin-medium-top uk-margin-xlarge-bottom uk-search uk-search-default">
                <a href="" class="uk-search-icon-flip" uk-search-icon=""></a>
                <input id="autocomplete" class="uk-search-input uk-form-large" type="search" autocomplete="off" name="s" placeholder="Cerca per parola chiave">
            </form>
        </div>
    </div>
</div>


<div class="uk-section uk-padding-remove-top uk-padding-remove-bottom">
    <div class="uk-container">
        <hr>
    </div>
</div>

<div class="uk-section">
    <div class="uk-container">
        <div class="uk-child-width-1-2@s text-dark" uk-grid="">
            <div>
                <h3 style="margin-bottom: 40px">Ultimi progetti censiti</h3>
                <ul class="uk-list uk-list-large uk-list-divider link-icon-right">
                    @foreach($ultimiCensiti as $progetto)
                        <li><a href="/articolo/view/{{ $progetto['id'] }}">{{ Helper::decodifica($progetto['titolo']) }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 style="margin-bottom: 40px">Ultimi progetti modificati</h3>
                <ul class="uk-list uk-list-large uk-list-divider link-icon-right">
                    @foreach($ultimiModificati as $progetto)
                        <li><a href="/articolo/view/{{ $progetto['id'] }}">{{ Helper::decodifica($progetto['titolo']) }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>


@include('layouts.footer')
@yield('footer')

</body>

</html>
