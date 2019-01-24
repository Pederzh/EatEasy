<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatiUtentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DatiUtenti', function (Blueprint $table) {
            $table->bigInteger('ID_utente')->unsigned(); //PRIMARY KEY & Foreign key
            $table->string('nome', 100);
            $table->string('cognome', 100);
             $table->string('username', 100)->unique();
            $table->date('data_nascita')->nullable(); //YYYY-MM-DD (coincide con l'iscrizione?)
            $table->string('sesso', 10);
            $table->string('latitudine'); //calcolata
            $table->string('longitudine'); //calcolata
            $table->boolean('newsletter');
            $table->boolean('consenso_trattamento_dati');
            $table->string('percorso_img')->unique()->nullable();//->default('immagine di default') ;
            $table->bigInteger('id_comune')->unsigned();//foreign key
            $table->integer('id_livello')->unsigned(); //foreign key
            $table->integer('id_lingua')->unsigned(); //foreign key
            //KEY
            $table->foreign('ID_utente')->references('id')->on('Users'); //(PK)
            $table->foreign('id_comune')->references('ID_comune')->on('Comuni');
            $table->foreign('id_livello')->references('ID_livello')->on('Privilegi');
            $table->foreign('id_lingua')->references('ID_lingua')->on('Lingue');
         
        });

                Schema::create('UtentiRicerche', function (Blueprint $table) {
            $table->bigInteger('id_utente')->unsigned(); //PRIMARY KEY & Foreign key
            $table->bigInteger('id_ricerca')->unsigned(); // primary key & Foreign key
            //KEY
            $table->primary(['id_utente', 'id_ricerca']);//(PK)
            $table->foreign('id_utente')->references('ID_utente')->on('DatiUtenti'); //(fk)
            $table->foreign('id_ricerca')->references('ID_ricerca')->on('Ricerche'); //(fk)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('DatiUtenti');
        Schema::drop('UtentiRicerche');

    }
}
