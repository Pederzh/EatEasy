<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormEsercentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FormEsercenti', function (Blueprint $table) {
            $table->increments('ID_domanda_esercente'); // (PK)
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


                Schema::create('EsercentiServizi', function (Blueprint $table) {
            $table->bigInteger('id_esercente')->unsigned(); //PRIMARY KEY & Foreign key
            $table->integer('id_domanda')->unsigned(); // primary key & Foreign key
            $table->integer('valutazione'); 
            //STORED TIME INFORMATIN
            $table->timestamps();
            //KEY
            $table->primary(['id_esercente', 'id_domanda']);//(PK)
            $table->foreign('id_esercente')->references('ID_esercente')->on('DatiEsercenti'); //(fk)
            $table->foreign('id_domanda')->references('ID_domanda_esercente')->on('FormEsercenti'); //(fk)
            
        });

                 Schema::create('EsercentiSclassi', function (Blueprint $table) {
            $table->integer('id_domanda_esercente')->unsigned(); // primary key & Foreign key
            $table->integer('id_sottoclasse')->unsigned(); // primary key & Foreign key
            //KEY
            $table->primary(['id_domanda_esercente', 'id_sottoclasse']);//(PK)
            $table->foreign('id_domanda_esercente')->references('ID_domanda_esercente')->on('FormEsercenti'); //(fk)
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
        Schema::drop('FormEsercenti');
        Schema::drop('EsercentiServizi');
        Schema::drop('EsercentiSclassi');
    }
}
