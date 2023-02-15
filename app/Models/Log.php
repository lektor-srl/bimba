<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    protected $table = 'log';
    public $incrementing = true;

    /**
     * @desc Creato metodo vuoto per disabilitare il campo updated_at automatico di eloquent
     * @param $value
     */
    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

}
