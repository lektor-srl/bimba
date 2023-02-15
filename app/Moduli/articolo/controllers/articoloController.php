<?php

namespace App\Moduli\articolo\controllers;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Moduli\articolo\models\Articolo;
use App\Moduli\articolo\models\ArticoloVersioni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use PHPUnit\Exception;
use Illuminate\Support\Facades\Auth;


class articoloController extends Controller
{
    public function index(Request $request, $id)
    {
        $page_data = [];

        $articolo = Articolo::find($id);

        abort_if((!$articolo), 404, "Risorsa non trovata");
        if(!boolval(env('MOSTRA_ARTICOLI_ELIMINATI'))){
            abort_if($articolo->eliminato, 505, "Questa risorsa è stata eliminata");
        }


        if(!empty($articolo->contenuto)){
            $articolo->contenuto = Helper::decodifica($articolo->contenuto);
        }
        if(!empty($articolo->titolo)){
            $articolo->titolo = Helper::decodifica($articolo->titolo);
        }


        return view('articolo.views.articolo')
            ->with(['articolo' => $articolo]);
    }

    public function viewVersione($id_articolo, $versione)
    {
        Log::info('articolo/viewVersione/'.$id_articolo);
        // Trovo l'id del record che sto cercando
        $record = DB::table('articoli_versioni')
            ->where('id_articolo', $id_articolo)
            ->where('versione', $versione)
            ->first();
        if(!empty($record->id)){
            $articolo = ArticoloVersioni::find($record->id);

            abort_if((!$articolo), 404, "Risorsa non trovata");
            if(!boolval(env('MOSTRA_ARTICOLI_ELIMINATI'))){
                abort_if($articolo->eliminato, 505, "Questa risorsa è stata eliminata");
            }

            if(!empty($articolo->contenuto)){
                $articolo->contenuto = Helper::decodifica($articolo->contenuto);
            }
            if(!empty($articolo->titolo)){
                $articolo->titolo = Helper::decodifica($articolo->titolo);
            }



            // Recupero tutte le versioni dell'articolo escludendo quella in cosiderazione
            $versioni = DB::table('articoli_versioni')
                ->where('id_articolo', $id_articolo)
                ->where('versione', '!=' , $versione)->get()->toArray();


            return view('articolo.views.versione-articolo')
                ->with(['articolo' => $articolo, 'versioni' => $versioni]);
        }else{
            echo "non è stato possibile prelevare i dati";
        }


    }

    public function edit(Request $request, $id)
    {
        // Controllo permessi utenti
        if(!Auth::user()->ruolo->write){
            Log::error('Unauthorized action');
            abort(403, 'Unauthorized action.');
        }


        $articolo = Articolo::find($id);

        abort_if((!$articolo), 404, "Risorsa non trovata");
        if(!boolval(env('MOSTRA_ARTICOLI_ELIMINATI'))){
            abort_if($articolo->eliminato, 505, "Questa risorsa è stata eliminata");
        }



        $data = $request->all();
        $toastMessage = new \stdClass();
        $toastMessage->show = (bool) true;

        if(isset($_POST) && !empty($_POST)){
            // Saving changes
            try {
                // Crypting the content
                $contentCypt = Helper::codifica($data['articleContent']);
                $titleCypt = Helper::codifica($data['articleTitle']);
                $excerptCypt = Helper::codifica($data['articleExcerpt']);

                DB::beginTransaction();
                // Inserimento nuova versione articolo
                if(intval($articolo->versione) > 0){
                    $this::registraVersione($id);
                }


                // Salvataggio articolo
                $articolo->contenuto = $contentCypt;
                $articolo->titolo = $titleCypt;
                $articolo->estratto = $excerptCypt;
                $articolo->versione += 1;
                $articolo->save();

                DB::commit();

                $toastMessage->message = (string) 'Modifiche salvate con successo!';
                $toastMessage->type = (string) 'success';

                Log::info('Modificato articolo con id: '. $articolo->id);
            }catch (\Exception $e){
                DB::rollBack();
                $toastMessage->message = (string) 'Errore nel salvataggio dei dati!';
                $toastMessage->type = (string) 'warning';
                Log::error($e->getMessage());
            }

            $articolo->contenuto = Helper::decodifica($articolo->contenuto);
            $articolo->estratto = Helper::decodifica($articolo->estratto);
            $articolo->titolo = Helper::decodifica($articolo->titolo);
            return redirect('/articolo/view/'.$id)->with([
                'toastMessage' => $toastMessage,
            ]);

        }else{
            // Editing section
            if(!empty($articolo->contenuto)){
                $articolo->contenuto = Helper::decodifica($articolo->contenuto);
            }
            if(!empty($articolo->titolo)){
                $articolo->titolo = Helper::decodifica($articolo->titolo);
            }
            if(!empty($articolo->estratto)){
                $articolo->estratto = Helper::decodifica($articolo->estratto);
            }

            return view('articolo.views.edit-articolo')
                ->with(['articolo' => $articolo]);
        }


    }

    public function new(Request $request)
    {
        $data = $request->all();
        $response = [];
        if (!empty($data['titolo']) && $data['titolo'] != '') {
            try {
                // Inserimento nuovo articolo
                DB::beginTransaction();

                $articolo = new Articolo;
                //$articolo->id = Helper::createId();
                $articolo->id_cliente = $data['id_cliente'];
                $articolo->id_utente = Auth::user()->id;
                $articolo->titolo = Helper::codifica($data['titolo']);
                $articolo->tipologia = 'progetto';
                $articolo->contenuto = env("DEFAULT_ARTICLE_CONTENT");
                $articolo->estratto = env("DEFAULT_ARTICLE_EXCERPT");
                $articolo->save();

                $articoloNew = Articolo::orderBy('id', 'desc')->limit(1)->first()->toArray();

                DB::commit();
                Log::info('Inserito nuovo articolo con id: '.$articoloNew['id']);
                return $response = ['esito' => true, 'messaggio' => 'Progetto inserito con successo!', 'id' => $articoloNew['id']];

            } catch (Exception $e) {
                DB::rollBack();
                return $response = ['esito' => false, 'messaggio' => 'Errore nell\'inserimento del nuovo record!'];
            }
        } else {
            return $response = ['esito' => false, 'messaggio' => 'Valore non valido!'];
        }
    }

    public function delete(Request $request)
    {
        //return $response = ['esito' => false, 'messaggio' => date('Y-m-d H:i:s')];
        $data = $request->all();
        $response = [];
        if (!empty($data['id_articolo']) && $data['id_articolo'] != '') {

            try {
                DB::beginTransaction();
                if(boolval($data['softDelete'])){
                    // todo:: inserire la data di cancellazione
                    // Nascondo dati referenziati
                    $query = DB::table('articoli_versioni')
                        ->where('id_articolo', $data['id_articolo'])
                        ->update(["eliminato" => 1, 'deleted_at' => date('Y-m-d H:i:s')]);

                    // Nascondo articolo
                    $query = DB::table('articoli')
                        ->where('id', $data['id_articolo'])
                        ->update(["eliminato" => 1, 'deleted_at' => date('Y-m-d H:i:s')]);
                }else{
                    // Cancellazione dati referenziati
                    $query = DB::table('articoli_versioni')
                        ->where('id_articolo', $data['id_articolo'])
                        ->delete();

                    // Cancellazione articolo
                    $query = DB::table('articoli')
                        ->where('id', $data['id_articolo'])
                        ->delete();
                }

                DB::commit();
                Log::info('Articolo eliminato con id: '. $data['id_articolo']);
                return $response = ['esito' => true, 'messaggio' => 'Articolo eliminato con successo!'];

            } catch (Exception $e) {
                DB::rollBack();
                return $response = ['esito' => false, 'messaggio' => 'Errore nella cancellazione del record!'];
            }
        } else {
            return $response = ['esito' => false, 'messaggio' => 'Valore non valido!'];
        }
    }

    public function printArticle($id)
    {
        $page_data = [];
        $articolo = Articolo::find($id);

        $page_data['contenuto'] = Helper::decodifica($articolo->contenuto);
        $page_data['titolo'] = Helper::decodifica($articolo->titolo);

        return view('articolo.views.print')
            ->with([
                'page_data' => $page_data,
            ]);
    }

    public function printVersionArticle($id_articolo, $versione)
    {
        // Trovo l'id del record che sto cercando
        $record = DB::table('articoli_versioni')
            ->where('id_articolo', $id_articolo)
            ->where('versione', $versione)
            ->first();

        if(!empty($record->id)){
            $articolo = ArticoloVersioni::find($record->id);

            $page_data['contenuto'] = Helper::decodifica($articolo->contenuto);
            $page_data['titolo'] = Helper::decodifica($articolo->titolo);

            return view('articolo.views.print')
                ->with([
                    'page_data' => $page_data,
                ]);
        }else{
            echo "non è possibile trovare il record";
        }

    }

    private function registraVersione($idArticolo)
    {
        $articoloStored = Articolo::find($idArticolo);
        try{
            DB::beginTransaction();
                $articoloNew = new ArticoloVersioni;

                //$articoloNew->id = Helper::createId();
                $articoloNew->id_articolo = $articoloStored->id;
                $articoloNew->id_cliente = $articoloStored->id_cliente;
                $articoloNew->id_utente = $articoloStored->id_utente;
                $articoloNew->tipologia = $articoloStored->tipologia;
                $articoloNew->contenuto = $articoloStored->contenuto;
                $articoloNew->estratto = $articoloStored->estratto;
                $articoloNew->titolo = $articoloStored->titolo;
                $articoloNew->versione = $articoloStored->versione;
                $articoloNew->created_at = $articoloStored->updated_at;

                $articoloNew->save();

            //Trovo l'ultimo id creato
                $articolo = Articolo::orderBy('id', 'desc')->limit(1)->first()->toArray();
                Log::info('Registrata nuova versione articolo con id: '.$articolo['id']);
            DB::commit();
            return true;
        }catch(Exception $e){
            DB::rollBack();
            return false;
        }

    }



}
