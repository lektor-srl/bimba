<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articoli_versioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->constrained('clienti');
            $table->foreignId('id_utente')->constrained('users');
            $table->foreignId('id_articolo')->constrained('articoli');
            $table->longText('titolo');
            $table->longText('contenuto');
            $table->string('tipologia', 15);
            $table->longText('estratto');
            $table->integer('versione');
            $table->boolean('eliminato')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
