<?php

namespace App\View\Components;

use App\Helper\Helper;
use App\Moduli\articolo\models\Articolo;
use App\Moduli\cliente\models\Cliente;
use Illuminate\View\Component;

class Topbar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.topbar')->with([
            "clienti" => $this->getClienti(),
            "progetti" => $this->getProgetti(),
        ]);
    }

    private function getClienti(){
        $clienti = [];
        $data = [];

        // Get data informations
        $record = Cliente::all();

        // Popolo l'array decodificando le informazioni
        foreach ($record as $data){
            $clienti[] = [
                'id' => $data->id,
                'nome' => Helper::decodifica($data->nome),
            ];
        }

        // Ordino alfabeticamente l'array
        array_multisort($clienti);

        return $clienti;
    }

    private function getProgetti(){
        $progetti = [];
        $data = [];

        // Get data informations
        if(boolval(env('MOSTRA_ARTICOLI_ELIMINATI'))){
            $record = Articolo::all()
                ->where('tipologia', 'progetto');
        }else{
            $record = Articolo::all()
                ->where('tipologia', 'progetto')
                ->where('eliminato', 0);
        }


        // Popolo l'array decodificando le informazioni
        foreach ($record as $data){
            $progetti[] = [
                'id' => $data->id,
                'titolo' => Helper::decodifica($data->titolo),
            ];
        }

        // Ordino alfabeticamente l'array
        array_multisort($progetti);

        return $progetti;
    }
}
