<?php

namespace App\Moduli\home\controllers;

use App\Http\Controllers\Controller;
use App\Helper\Helper;
use App\Models\ArticlesTypes;
use App\Moduli\articolo\models\Articolo;

class homeController extends Controller
{

    public function index(){
        // Mostra tutti gli articoli
        $lastProgetti = Articolo::select('id', 'titolo')
            ->where('id_tipologia', ArticlesTypes::TYPEPROGETTO)
            ->whereRaw((!env('MOSTRA_ARTICOLI_ELIMINATI')) ? 'eliminato = false' : '1=1')
            ->orderByDesc('created_at')
            ->limit(env('N_ULTIMI_ARTICOLI'))
            ->get()
            ->toArray();

        $lastCredenziali = Articolo::select('id', 'titolo')
            ->where('id_tipologia', ArticlesTypes::TYPECREDENZIALE)
            ->whereRaw((!env('MOSTRA_ARTICOLI_ELIMINATI')) ? 'eliminato = false' : '1=1')
            ->orderByDesc('created_at')
            ->limit(env('N_ULTIMI_ARTICOLI'))
            ->get()
            ->toArray();

        $lastRapportini = Articolo::select('id', 'titolo')
            ->where('id_tipologia', ArticlesTypes::TYPERAPPORTINO)
            ->whereRaw((!env('MOSTRA_ARTICOLI_ELIMINATI')) ? 'eliminato = false' : '1=1')
            ->orderByDesc('created_at')
            ->limit(env('N_ULTIMI_ARTICOLI'))
            ->get()
            ->toArray();

        return view('home.views.home')->with([
            'lastProgetti'=>$lastProgetti,
            'lastCredenziali'=>$lastCredenziali,
            'lastRapportini'=>$lastRapportini
        ]);
    }


}
