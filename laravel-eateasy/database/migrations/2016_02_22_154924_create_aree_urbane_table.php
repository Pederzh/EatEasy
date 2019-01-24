<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreeUrbaneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AreeUrbane', function (Blueprint $table) {
            $table->increments('ID_area'); //primary key 
            $table->string('area');
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
        Schema::drop('AreeUrbane');
    }
}
