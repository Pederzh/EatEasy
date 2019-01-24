<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormEsercente extends Model
{
    /* tabella con cui interagire */
    protected $table = 'formesercenti';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'ID_domanda_esercente';
    protected $fillable = [
        'numero_domanda', 'domanda', 'descrizione','link','diretta','attiva','id_sottoclasse'
        ];

	
	/* ritorna un'istanza del model "EsercenteServizio" in relazione al form esercente  */
    public function datiEsercente()
    {
        return $this->belongsToMany('App\datiEsercente', "EsercentiServizi", "id_esercente", "id_domanda")->withPivot('valutazione');
    }

	/* ritorna un'istanza del model "Sottoclasse" in relazione al form esercente */
    public function sottoclasse()
    {
        return $this->belongsToMany('App\Sottoclasse', "EsercentiSclassi", "id_domanda_esercente", "id_sottoclasse");
    }
}



