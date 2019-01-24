<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metratura extends Model
{
    /* tabella con cui interagire */
    protected $table = 'metrature';
	protected $primaryKey = 'ID_metratura';

    
    public function datiEsercenti()
	{
		return $this->hasMany('App\DatiEsercente','ID_metratura');
	}
}
