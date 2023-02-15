@extends('layouts.master')
@section('page-content')
    <!-- Alert box -->
    <div id="toastMessage" class="" uk-alert="">
        <a class="uk-alert-close" uk-close=""></a>
        <p></p>
    </div>

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
                        <header style="margin-bottom: 50px">
                            <h1 class="uk-article-title uk-margin-bottom">{{ $articolo->titolo }}
                                @if( Auth::user()->ruolo->write)
                                <a style="float: right; margin-left: 5px" href="/articolo/edit/{{ $articolo->id }}" id="editArticolo"><button class="uk-button uk-button-small uk-button-default" title="Modifica" uk-tooltip=""><span uk-icon="icon: pencil"></span></button></a>
                                @endif
                                <a target="_blank" style="float: right; margin-left: 5px" href="/articolo/printArticle/{{ $articolo->id }}"><button class="uk-button uk-button-small uk-button-default" title="Downlaod" uk-tooltip=""><span uk-icon="icon: cloud-download"></span></button></a>
                                @if(count($articolo->versioni) > 0)
                                    <a style="float: right; margin-left: 5px">
                                        <button class="uk-button uk-button-small uk-button-default">
                                            <select id="select-versione" data-articolo-id="{{ $articolo->id }}" style="border: none">
                                                <option selected value="null">Storico versioni</option>
                                                @foreach($articolo->versioni as $versione)
                                                    <option value="{{ $versione->versione }}">V. {{ $versione->versione }} - {{ date_format($versione->created_at, 'd/m/y H:i') }}</option>
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
                                            <p class="uk-article-meta uk-margin-remove-top">Creato: {{ date_format($articolo->created_at,"d/m/y H:i") }}<br>
                                                Ultima modifica: {{ date_format($articolo->updated_at,"d/m/y H:i") }}<br>
                                               V. {{ $articolo->versione }}</p>
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

    <script>

        @if(Session::has('toastMessage'))
        showToastMessage('<?= Session::get('toastMessage')->type ?>', '<?= Session::get('toastMessage')->message ?>');
        @endif


        function showToastMessage(type, message){
            $("#toastMessage").addClass('uk-alert-'+type);
            $("#toastMessage > p").text(message);
            $("#toastMessage").slideDown(300);
            setTimeout(function(){
                $("#toastMessage").slideUp(300);
            }, 2500)
        }
    </script>
@endsection
