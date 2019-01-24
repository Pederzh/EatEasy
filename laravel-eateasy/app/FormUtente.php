<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormUtente extends Model
{
    /* tabella con cui interagire */
    protected $table = 'formutenti';
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'ID_domanda_utente';
    protected $fillable =[
        'num_domanda', 'domanda', 'descrizione', 'link', 'diretta', 'attiva', 'id_sottoclasse'
    ];
    
    /*ritorna un'istanza del model "DomandaSottolasse" in realazione all'utente*/
    public function sottoclasse()
    {
    	return $this->belongsToMany('App\Sottoclasse', "UtentiSclassi", "ID_domanda_utente", "id_sottoclasse");
    }
    
    /*ritorna un'istanza del model "UtenteDifficolta" in realazione all'utente*/
    /*
    public function utenteDifficolta()
    {
    	return $this->hasMany('App\UtenteDifficolta', 'ID_domanda_utente');
    }
    */
    public function datiUtente(){
        return $this->belongsToMany('App\DatiUtente', "UtentiDifficolta", "id_utente", "id_domanda");
    }
    
}
