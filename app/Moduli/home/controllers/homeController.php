<?php

namespace App\Moduli\home\controllers;

use App\Http\Controllers\Controller;
use App\Helper\Helper;
use App\Moduli\articolo\models\Articolo;

class homeController extends Controller
{

    public function index(){
        if(boolval(env('MOSTRA_ARTICOLI_ELIMINATI'))){
            // Mostra tutti gli articoli
            $ultimiCensiti = Articolo::select('id', 'titolo')
                ->orderByDesc('created_at')
                ->limit(env('N_ULTIMI_ARTICOLI'))
                ->get()
                ->toArray();

            $ultimiModificati = Articolo::select('id', 'titolo')
                ->orderByDesc('updated_at')
                ->limit(env('N_ULTIMI_ARTICOLI'))
                ->get()
                ->toArray();
        }else{
            // Mostra solo gli articoli non eliminati
            $ultimiCensiti = Articolo::select('id', 'titolo')
                ->where('eliminato', 0)
                ->orderByDesc('created_at')
                ->limit(env('N_ULTIMI_ARTICOLI'))
                ->get()
                ->toArray();

            $ultimiModificati = Articolo::select('id', 'titolo')
                ->where('eliminato', 0)
                ->orderByDesc('updated_at')
                ->limit(env('N_ULTIMI_ARTICOLI'))
                ->get()
                ->toArray();
        }


        return view('home.views.home')->with([
            'ultimiCensiti'=>$ultimiCensiti,
            'ultimiModificati'=>$ultimiModificati
        ]);
    }


}
