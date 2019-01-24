<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Province', function (Blueprint $table) {
            $table->bigIncrements('ID_provincia');//primary key
            $table->string('nome_provincia'); 
            $table->string('sigla', 4);
            $table->bigInteger('id_regione')->unsigned(); //Foreign key
            //STORED TIME INFORMATIN
            $table->timestamps();
            //KEY
            $table->foreign('id_regione')->references('ID_regione')->on('Regioni') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Province');
    }
}
