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
    public function index(Request $request, $key)
    {
        $page_data = [
            'progetti' => [],
            'credenziali' => [],
            'rapportini' => [],
        ];

        $articoli = Articolo::where('eliminato', false)->orderBy('created_at', 'desc')->get();
        foreach ($articoli as $articolo){

            $articolo->titolo = Helper::decodifica($articolo->titolo);
            $articolo->contenuto = Helper::decodifica($articolo->contenuto);
            $articolo->estratto = Helper::decodifica($articolo->estratto);

            if(
                str_contains($articolo->titolo, $key) ||
                str_contains($articolo->contenuto, $key) ||
                str_contains($articolo->estratto, $key)
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
