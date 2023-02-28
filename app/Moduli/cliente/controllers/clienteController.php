<?php

namespace App\Moduli\cliente\controllers;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Moduli\cliente\models\Cliente;
use Illuminate\Support\Facades\DB;

class clienteController extends Controller
{
    public function index(Request $request, $id){

        $progetti = [];
        $credenziali = [];
        $rapportini = [];

        // Carico i dati del cliente con tutti i dati associati
        $cliente = Cliente::find($id);
        $cliente->nome = Helper::decodifica($cliente->nome);

        // Ciclo i progetti e li salvo
        foreach ($cliente->articoli as $articolo) {
            // Salto gli articoli eliminati se non c'è il parametro
            if(boolval($articolo['eliminato']) && !boolval(env('MOSTRA_ARTICOLI_ELIMINATI'))){
                continue;
            }

            switch ($articolo->tipologia->name){
                case 'progetto':
                    $progetti[] = [
                        'id' => $articolo['id'],
                        'titolo' => Helper::decodifica($articolo['titolo']),
                        'estratto' => Helper::decodifica($articolo['estratto']),
                    ];
                    break;

                case 'credenziale':
                    $credenziali[] = [
                        'id' => $articolo['id'],
                        'titolo' => Helper::decodifica($articolo['titolo']),
                        'estratto' => Helper::decodifica($articolo['estratto']),
                    ];
                    break;

                case 'rapportino':
                    $rapportini[] = [
                        'id' => $articolo['id'],
                        'titolo' => Helper::decodifica($articolo['titolo']),
                        'estratto' => Helper::decodifica($articolo['estratto']),
                    ];
                    break;
            }

        }

        $page_data = [
            'cliente' => $cliente,
            'progetti' => $progetti,
            'credenziali' => $credenziali,
            'rapportini' => $rapportini,
        ];

        return view('cliente.views.cliente')
            ->with([
                'clienti' => $this->getClienti(),
                'page_data' => $page_data,
            ]);
    }

    public function new(Request $request){
        $data = $request->all();
        $response = [];
        if(!empty($data['name']) && $data['name'] != ''){
            try {
                // Inserimento nuovo cliente
                DB::beginTransaction();

                    $cliente = new Cliente;
                    //$cliente->id = Helper::createId();
                    $cliente->nome = Helper::codifica(trim($data['name']));
                    $cliente->save();

                    //Trovo l'ultimo id creato
                    $clienteNew = Cliente::orderBy('id', 'desc')->limit(1)->first()->toArray();

                DB::commit();
                return $response = ['esito' => true, 'messaggio' => 'Cliente inserito con successo!', 'id' => $clienteNew['id']];
            }catch(Exception $e){
                DB::rollBack();
                return $response = ['esito' => false, 'messaggio' => 'Errore nell\'inserimento del nuovo record!'];
            }
        }else{
            return $response = ['esito' => false, 'messaggio' => 'Valore non valido!'];
        }
    }

    /**
     * @return array
     * Carica i clienti dal DB
     */
    private function getClienti(){
        $clienti = [];
        $data = [];

        // Get data informations
        $record = Cliente::all();

        // Popolo l'array decodificando le informazioni ed estraggo il numero di progetti per cliente
        foreach ($record as $data){
            if(boolval(env('MOSTRA_ARTICOLI_ELIMINATI'))){
                $progetti = DB::selectOne("SELECT DISTINCT COUNT(*) AS count FROM articoli WHERE id_cliente = '$data->id'");
            }else{
                $progetti = DB::selectOne("SELECT DISTINCT COUNT(*) AS count FROM articoli WHERE id_cliente = '$data->id' AND eliminato = false");
            }


            $clienti[] = [
                'id' => $data->id,
                'nome' => Helper::decodifica($data->nome),
                'numProgetti' => $progetti->count,
            ];
        }


        // Ordino alfabeticamente l'array
        array_multisort($clienti);

        return $clienti;
    }
}
