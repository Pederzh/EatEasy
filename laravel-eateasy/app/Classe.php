<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    /* Tabella con cui interagire */
    protected $table = 'classi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'ID_classe';
    protected $fillable = [
    	
    ];

    /* ritorna un'istanza del model "Sottoclasse" in relazione alla classe */
    public function sottoclasse()
    {
    	return $this->hasMany('App\Sottoclasse');
    }

    /* ritorna un'istanza del model "EsercenteClasse" in relazione alla classe */
    public function datiEsercente()
    {
    	return $this->belongsToMany('App\DatiEsercente', "EsercentiClassi", "id_esercente", "id_classe")->withPivot('valutazione_classe');
        //per accedere al punteggio della classe per ogni ristorante
        //usare: $classe = Classe::where(%condizone)->get(); $myvar = $classe->datiEsercente()->pivot->valutazione_classe;
    }
}
