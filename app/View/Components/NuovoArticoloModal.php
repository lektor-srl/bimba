<?php

namespace App\View\Components;

use App\Moduli\cliente\models\Cliente;
use Illuminate\View\Component;

class NuovoArticoloModal extends Component
{

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
        // Carica i clienti
        $clienti = Cliente::all()->toArray();

        return view('components.nuovo-articolo-modal')->with([
            "clienti" => $clienti
        ]);
    }
}
