<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comune extends Model
{
    /* tabella con cui interagire */
    protected $table = 'comuni';
    protected $primaryKey = 'ID_comune';

	public function datiEsercenti()
	{
		return $this->hasMany('App\DatiEsercente','ID_comune');
	}

	public function datiUtenti()
	{
		return $this->hasMany('App\DatiUtente','ID_comune');
	}

	public function provincia()
	{
		return $this->belongsTo('App\Provincia');
	}
}
