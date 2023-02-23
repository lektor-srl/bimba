<?php

namespace App\Moduli\articolo\models;

use App\Moduli\cliente\models\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ArticoloBackup extends Model
{
    protected $connection = 'backup';

    protected $table = 'articoli';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
