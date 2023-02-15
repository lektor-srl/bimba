<?php

namespace App\Moduli\cliente\models;

use App\Moduli\articolo\models\Articolo;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{


    protected $table = 'clienti';
    public $incrementing = false;
    protected $keyType = 'string';

    public function articoli(){
        return $this->hasMany(Articolo::class, 'id_cliente', 'id');
    }

}
