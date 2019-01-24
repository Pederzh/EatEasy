<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegioniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Regioni', function (Blueprint $table) {
            $table->bigIncrements('ID_regione');//primary key
            $table->string('nome_regione'); 
            $table->bigInteger('id_nazione')->unsigned(); //Foreign key
            //STORED TIME INFORMATIN
            $table->timestamps();
            //KEY
            $table->foreign('id_nazione')->references('ID_nazione')->on('Nazioni') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Regioni');
    }
}
