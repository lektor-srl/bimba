<?php

namespace App\Moduli\ruolo\controllers;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Moduli\articolo\models\Articolo;
use App\Moduli\articolo\models\ArticoloVersioni;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use App\Moduli\cliente\models\Cliente;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;


class ruoloController extends Controller
{

    public function index()
    {
        $ruoli = Role::all();
        return view('ruolo.views.ruolo')
            ->with(['ruoli' => $ruoli]);
    }

    public function edit(Request $request){
        $data = $request->all();
        $result = [];
        if(!empty($data)){
            foreach ($data['ruoli'] as $ruolo){
                try {
                    DB::beginTransaction();
                    $sql = DB::table('roles')
                        ->where('ruolo', $ruolo['name'])
                        ->update(['write' => boolval($ruolo['write']), 'read' => boolval($ruolo['read']), 'system' => boolval($ruolo['system'])]);
                    DB::commit();
                }catch (Exception $e){
                    return json_encode($e);
                }
            }
        }
        return json_encode($result = [
            'esito' => true,
        ]);
    }

}
