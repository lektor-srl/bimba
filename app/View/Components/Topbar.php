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
        return view('components.topbar');
    }

}
