@extends('layouts.master')
@section('page-content')
    <!-- breadcrumb -->
    <div class="uk-section section-sub-nav uk-padding-remove">
        <div class="uk-container">
            <div uk-grid="">
                <div class="uk-width-2-3@m">
                    <ul class="uk-breadcrumb uk-visible@m">
                        <li><a href="/">Home</a></li>
                        <li><span>Gestione ruoli</span></li>
                    </ul>
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
                    <article class="uk-article">
                        <table class="uk-table uk-table-striped">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Lettura</th>
                                <th>Scrittura</th>
                                <th>System</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ruoli as $ruolo)
                                <tr class="ruolo" data-name="{{ $ruolo->ruolo }}">
                                    <td>{{ $ruolo->ruolo }}</td>
                                    <td><input type="checkbox" value="1"
                                               name="permission[{{ $ruolo->ruolo }}][read]"{{ ($ruolo->read) ? ' checked' : false }}>
                                    </td>
                                    <td><input type="checkbox" value="1"
                                               name="permission[{{ $ruolo->ruolo }}][write]"{{ ($ruolo->write) ? ' checked' : false }}>
                                    </td>
                                    <td><input type="checkbox" value="1"
                                               name="permission[{{ $ruolo->ruolo }}][system]"{{ ($ruolo->system) ? ' checked' : false }}>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <button id="save" class="uk-button uk-button-primary">Salva</button>
                    </article>
                </div>

            </div>
        </div>
    </div>
    <script>
        $("#save").click(function () {
            // Get data
            var ruoli = [];
            var read, write, system = null;

            $("table tr.ruolo").each(function () {
                // Check data
                var name = $(this).attr("data-name");
                read = 0;write = 0;system = 0;

                ($("input[name='permission[" + name + "][read]']").is(':checked')) ? read=1 : read=0;
                ($("input[name='permission[" + name + "][write]']").is(':checked')) ? write=1 : write=0;
                ($("input[name='permission[" + name + "][system]']").is(':checked')) ? system=1 : system=0;

                var element = {};
                element.name = $(this).attr("data-name");
                element.read = read;
                element.write = write;
                element.system = system;

                ruoli.push(element);

            });

            if(ruoli){
                var data = {
                    "_token": "{{ csrf_token() }}",
                    "ruoli": ruoli,
                }

                $.ajax({
                    url: 'ruoli/edit',
                    data: data,
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(result){
                        showToastMessage('success', 'Modifiche salvate con successo!');
                    },
                    error: function(){
                        showToastMessage('error', 'Errore nel salvataggio delle modifiche!');
                    },
                })
            }

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
