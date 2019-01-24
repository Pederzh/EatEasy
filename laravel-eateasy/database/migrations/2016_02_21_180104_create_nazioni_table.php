<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNazioniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Nazioni', function (Blueprint $table) {
            $table->bigIncrements('ID_nazione');//primary key
            $table->string('nome_nazione'); 
            //STORED TIME INFORMATIN
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
        Schema::drop('Nazioni');
    }
}