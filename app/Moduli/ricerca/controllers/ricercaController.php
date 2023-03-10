<?php

namespace App\Moduli\ricerca\controllers;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\ArticlesTypes;
use App\Moduli\articolo\models\Articolo;
use Illuminate\Http\Request;
use App\Moduli\cliente\models\Cliente;
use Illuminate\Support\Facades\DB;

class ricercaController extends Controller
{
    public function index(Request $request)
    {
        $page_data = [
            'progetti' => [],
            'credenziali' => [],
            'rapportini' => [],
        ];
        $data = $request->all();

        $key = strtolower($data['key']);
        $idCliente = $data['client'] ?? 0;
        $idCliente = (intval($idCliente)) ?: 0;


        $articoli = Articolo::where('eliminato', false)
            ->where('id_cliente', $idCliente ? '=' : '<>', $idCliente)
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($articoli as $articolo){

            $articolo->titolo = Helper::decodifica($articolo->titolo);
            $articolo->contenuto = Helper::decodifica($articolo->contenuto);
            $articolo->estratto = Helper::decodifica($articolo->estratto);

            if(
                str_contains(strtolower($articolo->titolo), $key) ||
                str_contains(strtolower($articolo->contenuto), $key) ||
                str_contains(strtolower($articolo->estratto), $key)
            ){
                switch ($articolo->id_tipologia){
                    case ArticlesTypes::TYPEPROGETTO:
                        $page_data['progetti'][] = $articolo;
                        break;
                    case ArticlesTypes::TYPECREDENZIALE:
                        $page_data['credenziali'][] = $articolo;
                        break;
                    case ArticlesTypes::TYPERAPPORTINO:
                        $page_data['rapportini'][] = $articolo;
                        break;
                }

            }
        }

        return view('ricerca.views.ricerca')
            ->with([
                'page_data' => $page_data,
            ]);

    }

}
