<?php

namespace App\Moduli\articolo\models;

use App\Moduli\cliente\models\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Articolo extends Model
{


    protected $table = 'articoli';
    public $incrementing = false;
    protected $keyType = 'string';

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }
    public function utente(){
        return $this->hasOne(User::class, 'id', 'id_utente');
    }
    public function versioni(){
        return $this->hasMany(ArticoloVersioni::class, 'id_articolo', 'id')->orderByDesc('versione');
    }

}
