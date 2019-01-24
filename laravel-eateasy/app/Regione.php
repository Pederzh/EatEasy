<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regione extends Model
{
    /* tabella con cui interagire */
    protected $table = 'regioni';
    
    public function province()
	{
		return $this->hasMany('App\Provincia');
	}

	public function nazione()
	{
		return $this->belongsTo('App\Nazione')
	}
}
