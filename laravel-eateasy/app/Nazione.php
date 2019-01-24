<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nazione extends Model
{
    /* tabella con cui interagire */
    protected $table = 'nazioni';
    
    public function regioni()
	{
		return $this->hasMany('App\Regione');
	}
}
