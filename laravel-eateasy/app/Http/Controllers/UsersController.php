<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use Storage;

use Auth; 		//importo la classe Auth per accedere allo user loggato
use App\User;	//classe User 
use App\DatiUtente;
use App\DatiEsercente;
use App\Comune;
use App\Lingua;
use App\AreaUrbana;
use App\TipoLocale;
use App\Metratura;
use App\FormUtente;
use App\FormEsercente;
use App\Classe;
use DB;

class UsersController extends Controller
{
	 public function __construct()
	{
		$this->middleware('auth',['except' =>  ['takeImg','takeImgRestaurant']]);
	}
	
	/**
	 * Mostra l'area riservata dello user
	 */
	public function showReservedArea()
	{	
		// controllo il tipo di utenza
		if (Auth::user()->isEsercente())
		{	//caso esercente
			$esercente = Auth::user();

			$datiesercente = $esercente->datiesercente()->get()->first();
			$comune = $datiesercente->comune()->get()->first();
			$area = $datiesercente->area()->get()->first();
			$locale = $datiesercente->locale()->get()->first();
			$metratura = $datiesercente->metratura()->get()->first();
			// per i punteggi
			$valutazioni = $datiesercente->classe()->get();
			// per i servizi offerti
			$formesercente = $datiesercente->formEsercente()->get();

			// ciclo per il retrieve di tutte le immagini caricate dall'esercente
			$test = true;
			$count = 1;
			
			while ($test) 
			{
				$path = '' . Auth::user()->id . '/' . $count . '.jpg'; 
				if (Storage::exists($path))
				{
					$immagini[$count] = 'getImg/' . Auth::user()->id . '/' . $count . '.jpg';
					$count++;
				}
				else
					$test = false;
			}
			// gestisco le classi e i relativi punteggi
			// prendo i punteggi delle classi che sono salvate
			foreach ($valutazioni as $valutazione)
			{
				//Arrivals
				if ($valutazione->nome_classe == 'Arrivals')
					$arrivals = $valutazione->pivot->valutazione_classe;
				//Access
				if ($valutazione->nome_classe == 'Access')
					$access = $valutazione->pivot->valutazione_classe;
				//Food
				if ($valutazione->nome_classe == 'Food')
					$food = $valutazione->pivot->valutazione_classe;
				//Baby
				if ($valutazione->nome_classe == 'Baby')
					$baby = $valutazione->pivot->valutazione_classe;
				//Technology
				if ($valutazione->nome_classe == 'Technology')
					$technology = $valutazione->pivot->valutazione_classe;
				//Green
				if ($valutazione->nome_classe == 'Green')
					$green = $valutazione->pivot->valutazione_classe;
			}
			// e se non sono state salvate allora metto 0
			//Arrivals
			if (!isset($arrivals))
				$arrivals = 0;
			//Access
			if (!isset($access))
				$access = 0;
			//Food
			if (!isset($food))
				$food = 0;
			//Baby
			if (!isset($baby))
				$baby = 0;
			//Technology
			if (!isset($technology))
				$technology = 0;
			//Green
			if (!isset($green))
				$green = 0;

			$chart = true;
			return view('esercenti.reservedarea',compact('esercente','datiesercente','comune','area','locale','metratura','formesercente','immagini','arrivals','access','food','baby','technology','green','chart'));
		}
		else
		{	// caso utente
			$utente = Auth::user();

			$datiutente = $utente->datiutente()->get()->first();
			$comune = $datiutente->comune()->get()->first();
			$lingua = $datiutente->lingua()->get()->first();

			$formutente = $datiutente->formUtente()->get();
 			
			$immagine = 'getImg/' . $datiutente->ID_utente . '/avatar.jpg';

			return view('utenti.reservedarea',compact('utente','datiutente','comune','lingua','formutente','immagine'));
		}
	}

    // ritorna l'immagine richiesta
    public function takeImg($id,$img)
    {
    	// prendo il file
	    $avatar = Storage::get('' . $id . '/' . $img);
	    // preparo l'immagine
	    $immagine = Image::make($avatar);
	    // controllo width e height
	    $width = $immagine->width();
	    $height = $immagine->height();

	    //eventualmente faccio il resize
	    if (($width < 500) and ($height < 500))
	    {
	    	$immagine = $immagine->resize(500,500)->response('jpg');
	    }
	    else
	    {
	    	$immagine = $immagine->crop(500,500)->response('jpg');
	    } 

        return $immagine;
    }

	public function takeImgRestaurant($id,$img)
    {
    	// prendo il file
	    $avatar = Storage::get('' . $id . '/' . $img);
	    // preparo l'immagine
	    $immagine = Image::make($avatar);
	    // controllo width e height
	    $width = $immagine->width();
	    $height = $immagine->height();

	    //eventualmente faccio il resize
	    if (($width < 1000) and ($height < 500))
	    {
	    	$immagine = $immagine->resize(1000,500)->response('jpg');
	    }
	    else
	    {
	    	$immagine = $immagine->crop(1000,500)->response('jpg');
	    } 

        return $immagine;
    }

}
