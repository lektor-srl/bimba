@extends('layouts.master')
@section('page-content')
    <!-- breadcrumb -->
    <div class="uk-section section-sub-nav uk-padding-remove">
        <div class="uk-container">
            <div uk-grid="">
                <div class="uk-width-2-3@m">
                    <ul class="uk-breadcrumb uk-visible@m">
                        <li><a href="/">Home</a></li>
                        <li><span>{{ $page_data['cliente'] }}</span></li>
                    </ul>
                </div>
                <div class="uk-width-1-3@m">
                    <div class="uk-margin">
                        <form class="uk-search uk-search-default">
                            <a href="" class="uk-search-icon-flip" uk-search-icon=""></a>
                            <input id="autocomplete" class="uk-search-input" type="search" autocomplete="off" placeholder="Cerca in {{ $page_data['cliente'] }}..">
                        </form>
                    </div>
                </div>
            </div>
            <div class="border-top"></div>
        </div>
    </div>

    <!-- main content page -->
    <div class="uk-section uk-section-small uk-padding-remove-bottom section-content">
        <div class="uk-container">
            <div class="uk-grid-medium" uk-grid="">
                @include('layouts.sidebar-clienti')
                @yield('sidebar-clienti')

                <div class="uk-width-3-4@m uk-flex-last@m">
                    <h1>{{ $page_data['cliente'] }} - Lista progetti</h1>

                    <ul class="list-faq" uk-accordion="multiple: true">
                        @if(count($page_data['progetti']) > 0)
                            @foreach($page_data['progetti'] as $progetto)
                                <li>
                                    <h3 class="uk-accordion-title uk-margin-remove">{{ $progetto['titolo'] }}</h3>
                                    <div class="uk-accordion-content">
                                        <p>{{ $progetto['estratto'] }}</p>
                                        <a href="/articolo/view/{{ $progetto['id'] }}" class="uk-button uk-button-small uk-button-primary">Vedi progetto <span uk-icon="icon: arrow-right"></span></a>
                                    </div>
                                </li>
                            @endforeach
                        @else
                        <p>Nessun progetto ancora censito</p>
                        @endif
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection
