<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLingueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Lingue', function (Blueprint $table) {
            $table->increments('ID_lingua'); //primary key 
            $table->string('lingua');
            $table->string('sigla_lingua',4);
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
        Schema::drop('Lingue');
    }
}
