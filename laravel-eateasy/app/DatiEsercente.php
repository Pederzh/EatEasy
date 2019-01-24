<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatiEsercente extends Model
{
    /* tabella con cui interagire */
    protected $table = 'datiesercenti';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'ID_esercente';
    protected $fillable = [
       'ID_esercente', 'nome_esercizio', 'nome_esercente', 'telefono', 'partita_iva', 'web_url', 'descrizione', 'info_orari', 'latitudine', 'longitudine', 'metratura', 'ultimo_rinnovo', 'percorso_img', 'numero_civico', 'indirizzo', 'id_comune', 'id_area', 'id_tipo_locale', 'id_metratura'
    ];

    /* ritorna un'istanza del model "User" in relazione all'esercente */
    public function user()
    {
    	return $this->belongsTo('App\User','ID_esercente');
    }

	/* ritorna un'istanza del model "EsercenteServizio" in relazione all'esercente */
    public function formEsercente()
    {
        return $this->belongsToMany('App\formEsercente', "esercentiServizi", "id_esercente", "id_domanda")->withPivot('valutazione');
    }

    /* ritorna un'istanza del model "EsercenteSottoclasse" in relazione all'esercente */
    public function sottoclasse()
    {
        return $this->belongsToMany('App\Sottoclasse', "EsercentiSottoclassi", "id_esercente", "id_sottoclasse")->withPivot('valutazione_sottoclasse');
        //per accedere al punteggio del ristorante per ogni sottoclasse
        //usare: $ristorante = DatiEsercente::where(%condizone)->get(); $myvar = $ristorante->sottoclasse()->pivot->valutazione_sottoclasse;
    }
	/* ritorna un'istanza del model "EsercenteSottoclasse" in relazione all'esercente */
    public function classe()
    {
    	return $this->belongsToMany('App\Classe', "EsercentiClassi", "id_esercente", "id_classe")->withPivot('valutazione_classe');
        //per accedere al punteggio del ristorante per ogni classe
        //usare: $ristorante = DatiEsercente::where(%condizone)->get(); $myvar = $ristorante->classe()->pivot->valutazione_classe;
    }

    /* ritorna un'istanza del model "Comune" in relazione all'esercente */
    public function comune()
    {
    	return $this->belongsTo('App\Comune','id_comune');
    }

    /* ritorna un'istanza del model "Area" in relazione all'esercente */
    public function area()
    {
    	return $this->belongsTo('App\AreaUrbana','id_area');
    }

    /* ritorna un'istanza del model "Locale" in relazione all'esercente */
    public function locale()
    {
    	return $this->belongsTo('App\TipoLocale','id_tipo_locale');
    }

    /* ritorna un'istanza del model "Metratura" in relazione all'esercente */
    public function metratura()
    {
    	return $this->belongsTo('App\Metratura','id_metratura');
    }

}
