<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaUrbana extends Model
{
    /* tabella con cui interagire */
    protected $table = 'areeurbane';
    protected $primaryKey = 'ID_area';

    public function datiEsercenti()
	{    
		return $this->hasMany('App\DatiEsercente','ID_area');
	}
}
