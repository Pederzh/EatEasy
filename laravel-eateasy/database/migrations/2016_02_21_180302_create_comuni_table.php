<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComuniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Comuni', function (Blueprint $table) {
            $table->bigIncrements('ID_comune');//primary key
            $table->string('nome_comune');
            $table->string('CAP',5);
            $table->string('codice_comune',4);
            $table->bigInteger('id_provincia')->unsigned(); //Foreign key
            //STORED TIME INFORMATIN
            $table->timestamps();
            //KEY
            $table->foreign('id_provincia')->references('ID_provincia')->on('Province') ;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Comuni');
    }
}
