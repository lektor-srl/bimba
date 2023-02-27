<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlesTypes extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'articoli_tipologie';
}
