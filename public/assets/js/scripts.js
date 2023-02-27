$(document).ready(function () {
    $("#select-versione").on('change', function () {
        var article_id = $(this).attr('data-articolo-id');
        var versione = $(this).val();

        if (versione != 'null') {
            getArticleVersion(article_id, versione);
        }

    });
});

function saveNuovoCliente(token) {
    var name = $("input[name='newCliente[nome]']").val();
    if (!name || name == '') {
        showModalMessage('warning', 'Nome non valido!');
        return 0;
    }
    var data = {
        "_token": token,
        "name": name
    };

    $.ajax({
        method: 'POST',
        url: '/nuovoCliente',
        data: data,
        success: function (e) {

            if (e.esito == true) {
                showModalMessage('success', e.messaggio);
                setTimeout(function () {
                    // Redirect al nuovo cliente
                    location.href = "/cliente/" + e.id;
                }, 1600)
            } else {
                showModalMessage('danger', e.messaggio);
            }
        },
        error: function (e) {
            showModalMessage('warning', 'Errore 500. Riprovare più tardi');
        }
    })
}

function saveNuovoProgetto(token) {
    var title = $("input[name='newProgetto[titolo]']").val();
    var id_cliente = $("select[name='newProgetto[id_cliente]']").val();
    var id_tipologia = $("select[name='newProgetto[id_tipologia]']").val();
    if (!title || title == '') {
        showModalMessage('warning', 'Titolo non valido!');
        return 0;
    }
    var data = {
        "_token": token,
        "titolo": title,
        "id_cliente": id_cliente,
        "id_tipologia": id_tipologia,
    };

    $.ajax({
        method: 'POST',
        url: '/nuovoArticolo',
        data: data,
        success: function (e) {

            if (e.esito == true) {
                showModalMessage('success', e.messaggio);
                setTimeout(function () {
                    // Redirect al nuovo articolo
                    location.href = "/articolo/edit/" + e.id;
                }, 1600)
            } else {
                showModalMessage('danger', e.messaggio);
            }
        },
        error: function (e) {
            showModalMessage('warning', e.message);
        }
    })
}


/**
 * Mostra un messaggio nella modale di inserimento nuovo cliente
 * @param type
 * @param message
 */
function showModalMessage(type = 'danger', message = '') {

    $(".modal-body > .alert")
        .addClass('alert-' + type)
        .text(message)
        .slideDown(300);

}

function getArticleVersion(article_id, versione) {
    location.href = "/articolo/viewVersione/" + article_id + "/" + versione;
}
