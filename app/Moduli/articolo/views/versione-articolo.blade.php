@extends('layouts.master')
@section('page-content')
    <!-- breadcrumb -->
    <div class="uk-section section-sub-nav uk-padding-remove">
        <div class="uk-container">
            <div uk-grid="">
                <div class="uk-width-2-3@m">
                    <ul class="uk-breadcrumb uk-visible@m">
                        <li><a href="/">Home</a></li>
                        <li><a href="/cliente/{{ $articolo->cliente->id }}">{{ Helper::decodifica($articolo->cliente->nome) }}</a></li>
                        <li><span>{{ $articolo->titolo }}</span></li>
                    </ul>
                </div>
                <div class="uk-width-1-3@m">
                    <div class="uk-margin">
                        <form class="uk-search uk-search-default">
                            <a href="" class="uk-search-icon-flip" uk-search-icon=""></a>
                            <input id="autocomplete" class="uk-search-input" type="search" autocomplete="off" placeholder="Cerca in {{ Helper::decodifica($articolo->cliente->nome) }}..">
                        </form>
                    </div>
                </div>
            </div>
            <div class="border-top"></div>
        </div>
    </div>

    <!-- main content page -->
    <div class="uk-section uk-section-small uk-padding-remove-bottom section-content">
        <div class="uk-container uk-position-relative">
            <div uk-grid="">
                <div class="uk-width-4-4@m">
                    <article class="uk-article">
                        <div class="uk-alert-warning" uk-alert="">
                            <a class="uk-alert-close" uk-close=""></a>
                            <p>Attenzione! Stai visualizzando uno storico di questo articolo creato il {{ $articolo->created_at }} indicizzata come V. {{ $articolo->versione }}. <a href="/articolo/view/{{ $articolo->id_articolo }}">Torna all'articolo aggiornato</a> </p>
                        </div>
                        <header style="margin-bottom: 50px">
                            <h1 class="uk-article-title uk-margin-bottom">{{ $articolo->titolo }}
                                <a target="_blank" style="float: right; margin-left: 5px" href="/articolo/printVersionArticle/{{ $articolo->id_articolo }}/{{ $articolo->versione }}"><button class="uk-button uk-button-small uk-button-default" title="Downlaod" uk-tooltip=""><span uk-icon="icon: cloud-download"></span></button></a>
                                @if($versioni)
                                    <a style="float: right; margin-left: 5px">
                                        <button class="uk-button uk-button-small uk-button-default">
                                            <select id="select-versione" data-call="versioni" data-articolo-id="{{ $articolo->id_articolo }}" style="border: none">
                                                <option value="null">Altre versioni</option>
                                                @foreach($versioni as $versione)
                                                    <option value="{{ $versione->versione }}">V. {{ $versione->versione }}</option>
                                                @endforeach
                                            </select>

                                        </button>
                                    </a>
                                @endif
                            </h1>
                            <div class="author-box uk-card">
                                <div class="uk-card-header uk-padding-remove">
                                    <div class="uk-grid-small uk-flex-middle  uk-position-relative" uk-grid="">
                                        <div class="uk-width-auto">
                                            <img class="uk-border-circle" width="40" height="40" src="/assets/img/users/default.jpg">
                                        </div>
                                        <div class="uk-width-expand">
                                            <h5 class="uk-card-title">{{ $articolo->utente->last_name . ' ' . $articolo->utente->name }}</h5>
                                            <p class="uk-article-meta uk-margin-remove-top">Creato: {{ $articolo->created_at }} - Modificato: {{ $articolo->updated_at }} - V. {{ $articolo->versione }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </header>

                        <section id="editorjs">
                            <?= $articolo->contenuto ?>
                        </section>

                    </article>
                </div>

            </div>
        </div>
    </div>

@endsection
