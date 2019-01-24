<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sottoclasse extends Model
{
    /* tabella con cui interagire */
    protected $table = 'sottoclassi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'ID_sottoclasse';
    protected $fillable = [
    	
    ];

    /* ritorna un'istanza del model "FormEsercente" in relazione alla sottoclasse */
    public function formEsercente()
    {
    	return $this->belongsToMany('App\FormEsercente', "EsercentiSclassi", "id_domanda_esercente", "id_sottoclasse");
    }

    /* ritorna un'istanza del model "EsercenteSottoclasse" in relazione alla sottoclasse */
    public function datiEsercente()
    {
    	return $this->belongsToMany('App\DatiEsercente', "EsercentiSottoclassi", "id_esercente", "id_sottoclasse")->withPivot('valutazione_sottoclasse');
        //per accedere al punteggio della sottoclasse di ogni ristorante: 
        //usare: $sottoclasse = Sottoclasse::where(%condizone)->get(); $myvar = $sottoclasse->datiEsercente()->pivot->valutazione_sottoclasse;
    }

        public function formUtente()
    {
        return $this->belongsToMany('App\FormUtente', "UtentiSclassi", "id_domanda_utente", "id_sottoclasse");
    }

    /* ritorna un'istanza del model "Classe" in relazione alla sottoclasse */
    public function classe()
    {
    	return $this->belongsTo('App\Classe');
    }
}
