<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoLocale extends Model
{
    /* tabella con cui interagire */
    protected $table = 'tipilocali';
    protected $primaryKey = 'ID_tipo_locale';
    
    public function datiEsercenti()
	{
		return $this->hasMany('App\DatiEsercente','ID_tipo_locale');
	}
}
