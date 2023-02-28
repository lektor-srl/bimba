@extends('layouts.master')
@section('page-content')
    <!-- breadcrumb -->
    <div class="uk-section section-sub-nav uk-padding-remove">
        <div class="uk-container">
            <div uk-grid="">
                <div class="uk-width-2-3@m">
                    <ul class="uk-breadcrumb uk-visible@m">
                        <li><a href="/">Home</a></li>
                        <li><span>ricerca</span></li>
                    </ul>
                </div>

            <div class="border-top"></div>
        </div>
    </div>

    <!-- main content page -->
    <div class="uk-section uk-section-small uk-padding-remove-bottom section-content">
        <div class="uk-container">
            <div class="uk-grid-medium" uk-grid="">


                <div class="uk-width-4-4@m uk-flex-last@m">
                    <h1>Risultati ricerca</h1>
                    <!-- Lista progetti -->
                    <h3 class="uk-margin-medium-top">Progetti</h3>
                    <ul class="list-faq" uk-accordion="multiple: true">
                        @if(count($page_data['progetti']) > 0)
                            @foreach($page_data['progetti'] as $progetto)
                                <li>
                                    <h4 class="uk-accordion-title uk-margin-remove">{{ \App\Helper\Helper::decodifica($progetto->cliente->nome).' - ' . $progetto->titolo }}</h4>
                                    <div class="uk-accordion-content">
                                        <p>{{ $progetto->estratto }}</p>
                                        <a href="/articolo/view/{{ $progetto->id }}" class="uk-button uk-button-small uk-button-primary">Vedi articolo <span uk-icon="icon: arrow-right"></span></a>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <p>Nessun progetto ancora censito</p>
                        @endif
                    </ul>

                    <!-- Credenziali -->
                    <h3 class="uk-margin-medium-top">Credenziali</h3>
                    <ul class="list-faq" uk-accordion="multiple: true">
                        @if(count($page_data['credenziali']) > 0)
                            @foreach($page_data['credenziali'] as $credenziale)
                                <li>
                                    <h4 class="uk-accordion-title uk-margin-remove">{{ \App\Helper\Helper::decodifica($credenziale->cliente->nome).' - ' . $credenziale->titolo }}</h4>
                                    <div class="uk-accordion-content">
                                        <p>{{ $credenziale->estratto }}</p>
                                        <a href="/articolo/view/{{ $credenziale->id }}" class="uk-button uk-button-small uk-button-primary">Vedi articolo <span uk-icon="icon: arrow-right"></span></a>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <p>Nessun oggetto ancora censito</p>
                        @endif
                    </ul>


                    <!-- Lista call -->
                    <h3 class="uk-margin-medium-top">Rapportini</h3>
                    <ul class="list-faq" uk-accordion="multiple: true">
                        @if(count($page_data['rapportini']) > 0)
                            @foreach($page_data['rapportini'] as $rapportino)
                                <li>
                                    <h4 class="uk-accordion-title uk-margin-remove">{{ \App\Helper\Helper::decodifica($rapportino->cliente->nome).' - ' . $rapportino->titolo }}</h4>
                                    <div class="uk-accordion-content">
                                        <p>{{ $rapportino->estratto }}</p>
                                        <a href="/articolo/view/{{ $rapportino->id }}" class="uk-button uk-button-small uk-button-primary">Vedi articolo <span uk-icon="icon: arrow-right"></span></a>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <p>Nessun oggetto ancora censito</p>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
