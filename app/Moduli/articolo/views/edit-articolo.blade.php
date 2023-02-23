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

    <!-- Alert box -->
    <div id="toastMessage" class="" uk-alert="">
        <a class="uk-alert-close" uk-close=""></a>
        <p></p>
    </div>

    <!-- main content page -->
    <div class="uk-section uk-section-small uk-padding-remove-bottom section-content">
        <div class="uk-container uk-position-relative">
            <div uk-grid="">
                <div class="uk-width-4-4@m">
                    <form action="/articolo/edit/{{ $articolo->id }}" method="post">
                        @csrf
                        <article class="uk-article">
                        <header style="margin-bottom: 50px">
                            <h1 class="uk-article-title uk-margin-bottom">
                                <input style="width: 70%; padding: 10px; border: none" type="text" name="articleTitle" value="{{ $articolo->titolo }}" />

                                <button type="submit" style="float: right; margin-left: 5px" id="salvaArticolo" class="uk-button uk-button-small uk-button-primary" title="Salva" uk-tooltip=""><span uk-icon="icon: check"></span></button>
                                <a href="/articolo/view/{{ $articolo->id }}" style="float: right; margin-left: 5px" class="uk-button uk-button-small uk-button-default" title="Annulla" uk-tooltip=""><span uk-icon="icon: reply"></span></a>
                                <span style="float: right; margin-left: 5px" id="eliminaArticolo" class="uk-button uk-button-small uk-button-danger" title="Elimina" uk-tooltip=""><span uk-icon="icon: close"></span></span>
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
                                                V. {{ $articolo->versione }} -> {{ $articolo->versione + 1 }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>

                        <textarea style="display: none" placeholder="Estratto articolo" id="articleExcerptInput" class="articleExcerptInput" name="articleExcerpt">{{ trim($articolo->estratto) }}</textarea>

                        <div id="loading"></div>
                        <textarea style="display: none" name="articleContent" id="articleContent"><?php echo $articolo->contenuto ?></textarea>

                    </article>
                    </form>
                </div>
            </div>
        </div>
    </div>
<style>

</style>

    <script src="https://cdn.tiny.cloud/1/r352qzf3bh7gwo6sgleksvm9q31sn793fhnt2kg9rqs48f5l/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>

        $(document).ready(function(){

            // Text editor init
            tinymce.init({
                selector: '#articleContent',
                //plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist pageembed powerpaste table advtable tinymcespellchecker',
                plugins: 'autolink lists table',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                min_height: 600,
            });

            $("#loading").hide();
            $("#articleContent").show();
            $("#articleExcerptInput").show();


            $("#eliminaArticolo").click(function(){
                if(confirm("Sicuro di voler eliminare questo articolo?")){
                    var softDelete = 1;

                    if(!confirm("Vuoi eseguire un soft delete?")){
                        softDelete = 0;
                    }

                    var data = {
                        "_token": "{{ csrf_token() }}",
                        "id_articolo": "{{ $articolo->id }}",
                        "softDelete" : softDelete
                    }


                    $.ajax({
                        url: '/cancellaArticolo',
                        data: data,
                        method: 'POST',
                        error: function(){
                            console.log("Errore di salvataggio");
                        },
                        complete: function(e){
                            var response = e.responseJSON;
                            if(response.esito){
                                showToastMessage('success', response.messaggio);
                                setTimeout(function(){
                                    location.href="/"
                                }, 2600);
                            }else{
                                showToastMessage('error', response.messaggio);
                            }
                        }
                    });
                }
            });


            @if(isset($toastMessage))
            showToastMessage('<?= $toastMessage->type ?>', '<?= $toastMessage->message ?>');
            @endif
        });


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
