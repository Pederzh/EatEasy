<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSottoclassiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Sottoclassi', function (Blueprint $table) {
            $table->increments('ID_sottoclasse'); //primary key 
            $table->string('nome_sottoclasse');
            $table->integer('id_classe')->unsigned(); //foreign key
           //STORED TIME INFORMATIN
            $table->timestamps();
            //KEY
            $table->foreign('id_classe')->references('ID_classe')->on('Classi'); //(fk)
        });

            //tabella ponte (pivot)
                Schema::create('EsercentiSottoclassi', function (Blueprint $table) {
            $table->bigInteger('id_esercente')->unsigned(); //PRIMARY KEY & Foreign key
            $table->integer('id_sottoclasse')->unsigned(); // primary key & Foreign key
            $table->integer('valutazione_sottoclasse'); 
            //KEY
            $table->primary(['id_esercente', 'id_sottoclasse']);//(PK)
            $table->foreign('id_esercente')->references('ID_esercente')->on('DatiEsercenti'); //(fk)
            $table->foreign('id_sottoclasse')->references('ID_sottoclasse')->on('Sottoclassi'); //(fk)
        });

                Schema::create('EsercentiClassi', function (Blueprint $table) {
            $table->bigInteger('id_esercente')->unsigned(); //PRIMARY KEY & Foreign key
            $table->integer('id_classe')->unsigned(); // primary key & Foreign key
            $table->integer('valutazione_classe'); 
            //KEY
            $table->primary(['id_esercente', 'id_classe']);//(PK)
            $table->foreign('id_esercente')->references('ID_esercente')->on('DatiEsercenti'); //(fk)
            $table->foreign('id_classe')->references('ID_classe')->on('Classi'); //(fk)
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Sottoclassi');
        Schema::drop('EsercentiSottoclassi');
        Schema::drop('EsercentiClassi');
    }
}
