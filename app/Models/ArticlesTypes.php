<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlesTypes extends Model
{
    use HasFactory;

    CONST TYPEPROGETTO       = 1;
    CONST TYPECREDENZIALE    = 2;
    CONST TYPERAPPORTINO     = 3;

    public $timestamps = false;
    protected $table = 'articoli_tipologie';

}
