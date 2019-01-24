<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferitiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Preferiti', function (Blueprint $table) {
            $table->bigInteger('id_esercente')->unsigned(); //PRIMARY KEY & Foreign key
            $table->bigInteger('id_utente')->unsigned(); //PRIMARY KEY & Foreign key
           //STORED TIME INFORMATIN
            $table->timestamps();
            //KEY
            $table->primary(['id_esercente', 'id_utente']);//(PK)
            $table->foreign('id_utente')->references('ID_utente')->on('DatiUtenti'); //(fk)
            $table->foreign('id_esercente')->references('ID_esercente')->on('DatiEsercenti'); //(fk)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Preferiti');
    }
}
