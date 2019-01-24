<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormUtentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FormUtenti', function (Blueprint $table) {
            $table->increments('ID_domanda_utente'); // (PK)
            $table->string('numero_domanda')->unique();
            $table->string('domanda');
            $table->string('descrizione');
            $table->string('link')->nullable();
            $table->boolean('cliccabile')->default(true);
            $table->boolean('diretta')->default(false);
            $table->boolean('attiva')->default(true);
            //STORED TIME INFORMATIN
            $table->timestamps();
            //KEY
         
        });

        //tabella ponte (pivot)
                Schema::create('UtentiDifficolta', function (Blueprint $table){
            $table->bigInteger('id_utente')->unsigned(); //PRIMARY KEY & Foreign key
            $table->integer('id_domanda')->unsigned(); // primary key & Foreign key
            //STORED TIME INFORMATIN
            $table->timestamps();
            //KEY
            $table->primary(['id_utente', 'id_domanda']);//(PK)
            $table->foreign('id_utente')->references('ID_utente')->on('DatiUtenti'); //(fk)
            $table->foreign('id_domanda')->references('ID_domanda_utente')->on('FormUtenti'); //(fk)
        });

                Schema::create('UtentiSclassi', function (Blueprint $table) {
            $table->integer('id_domanda_utente')->unsigned()->index();   // primary key & Foreign key
            $table->integer('id_sottoclasse')->unsigned()->index();      // primary key & Foreign key
            //KEY
            $table->primary(['id_domanda_utente', 'id_sottoclasse']);//(PK)
            $table->foreign('id_domanda_utente')->references('ID_domanda_utente')->on('FormUtenti'); //(fk)
            $table->foreign('id_sottoclasse')->references('ID_sottoclasse')->on('Sottoclassi'); //(fk)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('FormUtenti');
        Schema::drop('UtentiDifficolta');
        Schema::drop('UtentiSclassi');
    }
}
