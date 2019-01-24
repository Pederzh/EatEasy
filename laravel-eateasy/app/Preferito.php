<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preferito extends Model
{
    /* tabella con cui interagire */
    protected $table = 'preferiti';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	
    ];

    /* ritorna un'istanza del model "DatiEsercente" in relazione ai preferiti */
    public function datiEsercente()
    {
    	return $this->belongsTo('App\DatiEsercente');
    }

    /* ritorna un'istanza del model "DatiUtente" in relazione ai preferiti */
    public function datiUtente()
    {
    	return $this->belongsTo('App\DatiUtente');
    }
}
