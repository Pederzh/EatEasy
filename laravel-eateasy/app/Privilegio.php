<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilegio extends Model
{
    /* tabella con cui interagire */
    protected $table = 'privilegi';
     /*ritorna un'istanza del model "DatiUtente" in realazione all'utente*/
    public function datiUtente()
    {
        return $this->hasMany('App\DatiUtente');
    }
    
}
