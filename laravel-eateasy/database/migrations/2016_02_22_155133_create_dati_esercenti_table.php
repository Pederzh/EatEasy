<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatiEsercentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DatiEsercenti', function (Blueprint $table) {
            $table->bigInteger('ID_esercente')->unsigned(); //PRIMARY KEY & Foreign key
            $table->string('nome_esercizio', 100);
            $table->string('nome_esercente', 100);
            $table->string('cognome_esercente', 100);
            $table->string('telefono', 20)->unique();
            $table->string('partita_iva',20)->unique();
            $table->string('web_url')->nullable();
            $table->mediumText('descrizione');
            $table->string('info_orari');
            $table->string('latitudine'); //calcolata
            $table->string('longitudine'); //calcolata
            $table->string('metratura',100)->nullable(); 
            $table->date('ultimo_rinnovo')->nullable(); //YYYY-MM-DD (coincide con l'iscrizione?)
            $table->string('percorso_img')->unique();
            $table->string('numero_civico',10);
            $table->string('indirizzo');
            $table->bigInteger('id_comune')->unsigned();//foreign key
            $table->integer('id_area')->unsigned(); //foreign key
            $table->integer('id_tipo_locale')->unsigned();//foreign key
            $table->integer('id_metratura')->unsigned()->nulable(); //foreign key
            //KEY
            $table->foreign('ID_esercente')->references('id')->on('Users'); //(PK)
            $table->foreign('id_comune')->references('ID_comune')->on('Comuni');
            $table->foreign('id_area')->references('ID_area')->on('AreeUrbane');
            $table->foreign('id_tipo_locale')->references('ID_tipo_locale')->on('TipiLocali');
            $table->foreign('id_metratura')->references('ID_metratura')->on('Metrature');

            $table->timestamps(); //Adds created_at and updated_at columns.
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('DatiEsercenti');
    }
}
