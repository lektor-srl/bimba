<?php

use App\Moduli\ricerca\controllers\ricercaController;
use Illuminate\Support\Facades\Route;
use App\Moduli\home\controllers\homeController;
use App\Moduli\cliente\controllers\clienteController;
use App\Moduli\articolo\controllers\articoloController;
use App\Moduli\ruolo\controllers\ruoloController;

use Illuminate\Http\Request;
use App\Helper\Helper;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [homeController::class, 'index'])
    ->middleware(['auth']);

Route::get('/cliente/{id}', [clienteController::class, 'index'])
    ->middleware(['auth']);

Route::post('/nuovoCliente', [clienteController::class, 'new'])
    ->middleware(['auth']);

Route::get('/articolo/view/{id}', [articoloController::class, 'index'])
    ->middleware(['auth']);

Route::get('/articolo/viewVersione/{id_articolo}/{versione}', [articoloController::class, 'viewVersione'])
    ->middleware(['auth']);

Route::get('/articolo/edit/{id}', [articoloController::class, 'edit'])
    ->middleware(['auth']);

Route::post('/articolo/edit/{id}', [articoloController::class, 'edit'])
    ->middleware(['auth']);

Route::post('/articolo/uploadImage', [articoloController::class, 'uploadImage'])
    ->middleware(['auth']);

Route::post('/nuovoArticolo', [articoloController::class, 'new'])
    ->middleware(['auth']);

Route::post('/cancellaArticolo', [articoloController::class, 'delete'])
    ->middleware(['auth']);

Route::get('/articolo/printArticle/{id}', [articoloController::class, 'printArticle'])
    ->middleware(['auth']);

Route::get('/articolo/printVersionArticle/{id}/{versione}', [articoloController::class, 'printVersionArticle'])
    ->middleware(['auth']);

Route::get('/ruoli', [ruoloController::class, 'index'])
    ->middleware(['auth']);

Route::post('/ruoli/edit', [ruoloController::class, 'edit'])
    ->middleware(['auth']);

Route::get('/ricerca/{key}/{idCliente?}', [ricercaController::class, 'index'])
    ->middleware(['auth']);


require __DIR__.'/auth.php';



Route::get('/creaid', function(){
  return Helper::createId();
})->middleware(['auth']);

Route::get('/cripta', function(){
    return Helper::codifica('Lorem impsum è un testo segnaposto');
})->middleware(['auth']);
