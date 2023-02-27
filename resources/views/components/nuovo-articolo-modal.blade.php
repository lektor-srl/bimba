<div class="modal fade" id="nuovo-articolo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuovo progetto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text">Cliente</label>
                    </div>
                    <select name="newProgetto[id_cliente]" class="custom-select">
                        @foreach($clienti as $cliente)
                            <option value="{{ $cliente['id'] }}">{{ Helper::decodifica($cliente['nome']) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text">Tipologia</label>
                    </div>
                    <select name="newProgetto[id_tipologia]" class="custom-select">
                        @foreach($articoliTipologie as $tipologia)
                            <option value="{{ $tipologia['id'] }}">{{ $tipologia['name'] }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Titolo</span>
                    </div>
                    <input type="text" name="newProgetto[titolo]" class="form-control">
                </div>

                <div style="display: none" class="alert" role="alert"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                <button onclick="saveNuovoProgetto('{{ csrf_token() }}')" type="button" class="btn btn-primary">Salva</button>
            </div>
        </div>
    </div>
</div>
