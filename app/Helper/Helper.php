<?php
namespace App\Helper;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;


/**
 * Class Helper
 * Custom global functions
 */
class Helper
{
    /**
     * @param $value - Valore da codificare
     * @return mixed|string
     */
    public static function codifica($value){
        return Crypt::encrypt($value);
        //return $value;
    }

    public static function decodifica($value){
        return Crypt::decrypt($value);
        //return $value;
    }

    public static function createId(){
        return Str::random(12)
            .'-'.Str::random(5)
            .'-'.Str::random(3)
            .'-'.Str::random(6)
            .'-'.Str::random(6);
    }

    public static function removeLinkHtml($value){
        // Tolgo la prima parte
        if(str_contains($value, '<a href="')){
            $search = '';
            preg_match('/<[\s\S]+?>/', $value, $search);    // Cerca il format < "tutto il contenuto" >
            $value = str_replace($search, '', $value);

            // Tolgo la seconda parte
            $value = str_replace('</a>', '', $value);
        }

        return $value;
    }

}
