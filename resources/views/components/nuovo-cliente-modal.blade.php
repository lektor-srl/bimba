<div class="modal fade" id="nuovo-cliente-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuovo cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nome</span>
                    </div>
                    <input type="text" name="newCliente[nome]" class="form-control">
                </div>

                <div style="display: none" class="alert" role="alert"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                <button onclick="saveNuovoCliente('{{ csrf_token() }}')" type="button" class="btn btn-primary">Salva</button>
            </div>
        </div>
    </div>
</div>
