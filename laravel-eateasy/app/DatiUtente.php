<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatiUtente extends Model
{
    /* tabella con cui interagire */
    protected $table = 'datiutenti';
    public $timestamps = false;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'ID_utente';
    protected $fillable = [
        'ID_utente', 'nome', 'cognome', 'username', 'data_nascita', 'sesso', 'latitudine', 'longitudine', 'newsletter', 'consenso_trattamento_dati', 'percorso_img', 'id_comune', 'id_livello', 'id_lingua'
    ];
    /*ritorna un'istanza del model "User" in realazione all'utente*/
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    /*ritorna un'istanza del model "UtenteRicerca" in realazione all'utente*/
    public function ricerca()
    {
        return $this->belongsToMany('App\Ricerca', "UtenteRicerca", "id_utente", "id_ricerca");
    }
    /*ritorna un'istanza del model "UtenteDifficolta" in realazione all'utente*/
    /*
    public function utenteDifficolta()
    {
        return $this->hasMany('App\UtenteDifficolta', 'ID_utente');
    }
    */
    public function formUtente(){
        return $this->belongsToMany('App\formUtente', "UtentiDifficolta", "id_utente", "id_domanda");
    }
    /*ritorna un'istanza del model "Preferito" in realazione all'utente*/
    public function preferito()
    {
        return $this->hasMany('App\Preferito');
    }
    
    /* ritorna un'istanza del model "Comune" in relazione all'esercente */
    public function comune()
    {
    	return $this->belongsTo('App\Comune','id_comune');
    }
    
    /*ritorna un'istanza del model "Privilegi" in realazione all'utente*/
    public function privilegio()
    {
        return $this->belongsTo('App\Privilegio');
    }
    
    /*ritorna un'istanza del model "Lingua" in realazione all'utente*/
    public function lingua()
    {
        return $this->belongsTo('App\Lingua','id_lingua');
    }

}
