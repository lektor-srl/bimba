<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articoli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->constrained('clienti');
            $table->foreignId('id_utente')->constrained('users');
            $table->foreignId('id_tipologia')->constrained('articoli_tipologie');
            $table->longText('titolo');
            $table->longText('contenuto');
            //$table->string('tipologia', 15);
            $table->longText('estratto');
            $table->integer('versione')->default(0);
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
