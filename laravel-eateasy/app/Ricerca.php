<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ricerca extends Model
{
    /* tabella con cui interagire */
    protected $table = 'ricerche';
	protected $fillable[
		'testo_ricerca'
	];

    public function utente()
	{
		return $this->belongToMany('App\Utente',"UtenteRicerca", "id_utente", "id_ricerca");
	}
}
