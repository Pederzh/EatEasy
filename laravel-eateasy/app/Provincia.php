<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    /* tabella con cui interagire */
    protected $table = 'province';
    
    public function comuni()
	{
		return $this->hasMany('App\Comune');
	}

	public function regione()
	{
		return $this->belongsTo('App\Regione')
	}
}
