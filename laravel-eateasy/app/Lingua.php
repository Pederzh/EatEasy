<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lingua extends Model
{
    /* tabella con cui interagire */
    protected $table = 'lingue';
    protected $primaryKey = 'ID_lingua';
    /*ritorna un'istanza del model "DatiUtente" in realazione all'utente*/
    public function datiUtente()
    {
        return $this->hasMany('App\DatiUtente','ID_lingua');
    }
}
