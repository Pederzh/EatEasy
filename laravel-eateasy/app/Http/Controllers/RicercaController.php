<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

use App;
use Auth; 		//importo la classe Auth per accedere allo user loggato
use App\User;	//classe User 
use App\DatiUtente;
use App\DatiEsercente;
use App\Comune;
use App\FormUtente;
use App\FormEsercente;
use App\UtenteSclasse;
use App\Sottoclasse;
use DB;

class RicercaController extends Controller
{
    //
	public function showRicerca(Request $request)
    {
    	$luogo = array_pull($request,'luogo'); //prendo il luogo e lo rimuovo dall'array che ricevo ($request) cosi rimangono dentro solo i filtri
    	$filtri = $request->input();

    	$domande = array_keys($filtri);
    	$filtri_inseriti = Collection::make();
    	foreach ($domande as $domanda) {
    		$filtri_inseriti = $filtri_inseriti->merge(FormUtente::where('ID_domanda_utente', "=", $domanda)->get());
    	}

    	$classi = DB::table('Classi')->get();
		$questions = DB::table('Classi')
            ->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
            ->join('UtentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'utentisclassi.id_sottoclasse')
            ->rightjoin('FormUtenti', 'formutenti.ID_domanda_utente', '=', 'utentisclassi.id_domanda_utente')
            ->groupBy('FormUtenti.ID_domanda_utente')
            ->get();

        $ristoranti = null;

       if (($luogo==null) and ($filtri==null)){
    		//DALLA PAGINA NON RICEVO NULLA - (NAVBAR)
    		//dd("DALLA PAGINA NON RICEVO NULLA - (NAVBAR)");

    		//SE L'UTENTE E' LOGGATO
    		if (Auth::check()){
	    		// fetch dell'id
				$id = Auth::user()->id;
				//salvo l'utente avendolo trovato
				$utente = DatiUtente::find($id);

				//se non è un utente ma è un esercente
				if (! $utente){
					$message = "SI PREGA INSERIRE I TERMINI DI RICERCA";
					$ristoranti = Collection::make(); //non vi sono ristoranti
					return view('ricerca', compact('id','luogo', 'ristoranti', 'classi', 'questions', 'filtri', 'message'));
				}

				//se non ha scritto nessun luogo nella barra di ricerca quello di residenza
				$luogo_default = Comune::find($utente->id_comune);
				//prendo il luogo
				$l = $request->input('luogo', $luogo_default->nome_comune); //se non è stato inserito il luogo, di default metto il comune di residenza
				$luogo = Comune::where('nome_comune',"=", $l)->get()->first();
				$ristoranti = DatiEsercente::where('id_comune',"=", $luogo['ID_comune'])->get();
				$luogo = $luogo['nome_comune'];

				$filtri = $utente->FormUtente()->get(); //esigenze dell'utente loggato per autocompletamento filtri ricerca
				//UTENTE_______________________________________________________________________________________
				$utentisclassi = array();
				foreach ($filtri as $filtro)
					foreach ($filtro->sottoclasse()->get()->lists('ID_sottoclasse')->toArray() as $sottoclasse){
						$val = array();
						$val = array_add($val, 'num', 0);
						$val = array_add($val, 'tot', 0);
						$val = array_add($val, 'punteggio', 0);
						$utentisclassi = array_add($utentisclassi, $sottoclasse, $val);
					}


				$sottoclassi = array_keys($utentisclassi);
					foreach ($sottoclassi as $sottoclasse)
					{
					$nDomSC = DB::table('Classi')
					->select(DB::raw('count(*) as num'))
					->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
					->join('UtentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'utentisclassi.id_sottoclasse')
					->rightjoin('FormUtenti', 'formutenti.ID_domanda_utente', '=', 'utentisclassi.id_domanda_utente')
					->where('sottoclassi.id_sottoclasse', '=', $sottoclasse)
					->groupBy('sottoclassi.ID_sottoclasse')
					->get();
					$num = $nDomSC[0]->num;
					$utentisclassi[$sottoclasse]['tot'] = $num;
					}
				foreach ($filtri as $filtro)
					foreach ($filtro->sottoclasse()->get()->lists('ID_sottoclasse')->toArray() as $sottoclasse){
						$utentisclassi[$sottoclasse]['num'] += 1;
					}
				foreach ($sottoclassi as $sottoclasse)
					$utentisclassi[$sottoclasse]['punteggio'] = (integer)($utentisclassi[$sottoclasse]['num'] / $utentisclassi[$sottoclasse]['tot'] *100);
				//______________________________________________________________________________________________


				//RISTORANTI ___________________________________________________________________________________
				$esecentisclassi = array();
				foreach ($ristoranti as $ristorante){
					$r_sottoclassi = $ristorante->sottoclasse()->get();

					$sott = array();
					foreach ($r_sottoclassi as $r_sottoclasse){
						
						foreach ($sottoclassi as $sottoclasse){
								$val = array();
								$val = array_add($val, 'rist', $ristorante->ID_esercente);
								$val = array_add($val, 'valutazione', 0);
								$val = array_add($val, 'punteggio', 1);
								$val = array_add($val, 'posizione', 0);
								$val = array_add($val, 'scarto', 1);

								$sott = array_add($sott, $sottoclasse, $val);

							if($r_sottoclasse->ID_sottoclasse == $sottoclasse){
								$sott[$r_sottoclasse->ID_sottoclasse]['valutazione'] = $r_sottoclasse->pivot->valutazione_sottoclasse;
								$sott[$r_sottoclasse->ID_sottoclasse]['punteggio'] = $r_sottoclasse->pivot->valutazione_sottoclasse / $utentisclassi[$r_sottoclasse->ID_sottoclasse]['punteggio']; //in questa fase è ancora rapporto, poi diventerà punteggio quando divido per la posizione corrente
								if ($sott[$r_sottoclasse->ID_sottoclasse]['punteggio']<1)
									$sott[$r_sottoclasse->ID_sottoclasse]['scarto'] = -1*($r_sottoclasse->pivot->valutazione_sottoclasse - $utentisclassi[$r_sottoclasse->ID_sottoclasse]['punteggio']);
							}
						}
					}
					$sott = array_add($sott, 'punteggio_tot', 0);
					$esecentisclassi = array_add($esecentisclassi, $ristorante->ID_esercente, $sott);
				}

				foreach ($sottoclassi as $sottoclasse){
					$cont = 0;
					$sott = array();
					foreach ($ristoranti as $ristorante){
						$pos = array();
						$pos = array_add($pos, 'valutazione', $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['valutazione']);
						$sott = array_add($sott, $ristorante->ID_esercente, $pos);
					}
					//dd($sott);
					$sott = array_reverse(array_sort($sott, function($value){
						return $value['valutazione'];
					}),true);
					//print_r($sott);
					foreach ($ristoranti as $ristorante){

						$p = array_search($ristorante->ID_esercente, array_keys($sott));
						$esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['posizione'] = $p+1;
						$esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'] = $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'] / $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['posizione']; 
					}	
				}

				foreach ($ristoranti as $ristorante){
					$punteggio_tot = 1;
					$scarto = 0;
					$cont = 0;
					foreach ($sottoclassi as $sottoclasse){
						$punteggio_tot = $punteggio_tot * $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'];
						if($esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['scarto']>1){
							$cont++;
							$scarto = $scarto + $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['scarto'];
						}
					}
					if ($scarto == 0){
						$media_scarto = 1; 
					}
					else{
						$media_scarto = $scarto / $cont;
					}
					$esecentisclassi[$ristorante->ID_esercente]['punteggio_tot'] = $punteggio_tot / $media_scarto;
				}

				//ORDINAMENTO
				$esecentisclassi = array_reverse(array_sort($esecentisclassi, function($value){
					return $value['punteggio_tot'];
				}),true);
				//RETRIEVE DEI RISTORANTI
				$rist = $ristoranti;
				$esecentisclassi = array_keys($esecentisclassi); 
				$ristoranti = collect([]);
				foreach ($esecentisclassi as $esercente) {
					$app = $rist->where('ID_esercente',$esercente);
					$ristoranti = $ristoranti->merge($app);
				}
				//_______________________________________________________________________________________________
				
				if ($ristoranti->isEmpty()){
					$message="NESSUN RISULTATO CONFORME AI CRITERI RICHIESTI";
				}
				//ALGORITMO FILTRO E RICERCA
				return view('ricerca', compact('id','luogo', 'ristoranti', 'classi', 'questions', 'filtri', 'message'));
    		}
    		//SE NON E' UTENTE LOGGATO MA E' UN GUEST (non ho informazioni sulle sue esigenze)
			//non precompilo i filtri e aspetto che li inserisca lui e rifaccia la ricerca
			{
				$l = $luogo;
	    		$luogo = Comune::where('nome_comune',"=", $l)->get()->first();
	    		$ristoranti = DatiEsercente::where('id_comune',"=", $luogo['ID_comune'])->get();
	    		$luogo = $luogo['nome_comune'];
				$message = "SI PREGA DI INSERIRE I TERMINI DI RICERCA";
				return view('ricerca', compact('id','luogo', 'ristoranti', 'classi', 'questions', 'filtri', 'message'));

			}
    	}
    	{
    	if (($luogo!=null) and ($filtri==null)){
    		//DALLA PAGINA RICEVO SOLO IL LUOGO - (HOMEPAGE)
    		//dd("DALLA PAGINA RICEVO SOLO IL LUOGO - (HOMEPAGE)");

    		//SE L'UTENTE E' LOGGATO
    		if (Auth::check()){
	    		// fetch dell'id
				$id = Auth::user()->id;
				//salvo l'utente avendolo trovato
				$utente = DatiUtente::find($id);

				//se non è un utente ma è un esercente
				if (! $utente){
					$l = $luogo;
		    		$luogo = Comune::where('nome_comune',"=", $l)->get()->first();
		    		$ristoranti = DatiEsercente::where('id_comune',"=", $luogo['ID_comune'])->get();
		    		$luogo = $luogo['nome_comune'];
		   			if ($ristoranti->isEmpty()){
						$message="NESSUN RISULTATO CONFORME AI CRITERI RICHIESTI";
					}
		    		return view('ricerca', compact('id','luogo', 'ristoranti', 'classi', 'questions', 'filtri', 'message'));
				}

	    		$l = $luogo;
	    		$luogo = Comune::where('nome_comune',"=", $l)->get()->first();
				$ristoranti = DatiEsercente::where('id_comune',"=", $luogo['ID_comune'])->get();
				$luogo = $luogo['nome_comune'];

				$filtri = $utente->FormUtente()->get(); //esigenze dell'utente loggato per autocompletamento filtri ricerca

				//UTENTE_______________________________________________________________________________________
				$utentisclassi = array();
				foreach ($filtri as $filtro)
					foreach ($filtro->sottoclasse()->get()->lists('ID_sottoclasse')->toArray() as $sottoclasse){
						$val = array();
						$val = array_add($val, 'num', 0);
						$val = array_add($val, 'tot', 0);
						$val = array_add($val, 'punteggio', 0);
						$utentisclassi = array_add($utentisclassi, $sottoclasse, $val);
					}


				$sottoclassi = array_keys($utentisclassi);
					foreach ($sottoclassi as $sottoclasse)
					{
					$nDomSC = DB::table('Classi')
					->select(DB::raw('count(*) as num'))
					->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
					->join('UtentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'utentisclassi.id_sottoclasse')
					->rightjoin('FormUtenti', 'formutenti.ID_domanda_utente', '=', 'utentisclassi.id_domanda_utente')
					->where('sottoclassi.id_sottoclasse', '=', $sottoclasse)
					->groupBy('sottoclassi.ID_sottoclasse')
					->get();
					$num = $nDomSC[0]->num;
					$utentisclassi[$sottoclasse]['tot'] = $num;
					}
				foreach ($filtri as $filtro)
					foreach ($filtro->sottoclasse()->get()->lists('ID_sottoclasse')->toArray() as $sottoclasse){
						$utentisclassi[$sottoclasse]['num'] += 1;
					}
				foreach ($sottoclassi as $sottoclasse)
					$utentisclassi[$sottoclasse]['punteggio'] = (integer)($utentisclassi[$sottoclasse]['num'] / $utentisclassi[$sottoclasse]['tot'] *100);
				//______________________________________________________________________________________________


				//RISTORANTI ___________________________________________________________________________________
				$esecentisclassi = array();
				foreach ($ristoranti as $ristorante){
					$r_sottoclassi = $ristorante->sottoclasse()->get();

					$sott = array();
					foreach ($r_sottoclassi as $r_sottoclasse){
						
						foreach ($sottoclassi as $sottoclasse){
								$val = array();
								$val = array_add($val, 'rist', $ristorante->ID_esercente);
								$val = array_add($val, 'valutazione', 0);
								$val = array_add($val, 'punteggio', 1);
								$val = array_add($val, 'posizione', 0);
								$val = array_add($val, 'scarto', 1);

								$sott = array_add($sott, $sottoclasse, $val);

							if($r_sottoclasse->ID_sottoclasse == $sottoclasse){
								$sott[$r_sottoclasse->ID_sottoclasse]['valutazione'] = $r_sottoclasse->pivot->valutazione_sottoclasse;
								$sott[$r_sottoclasse->ID_sottoclasse]['punteggio'] = $r_sottoclasse->pivot->valutazione_sottoclasse / $utentisclassi[$r_sottoclasse->ID_sottoclasse]['punteggio']; //in questa fase è ancora rapporto, poi diventerà punteggio quando divido per la posizione corrente
								if ($sott[$r_sottoclasse->ID_sottoclasse]['punteggio']<1)
									$sott[$r_sottoclasse->ID_sottoclasse]['scarto'] = -1*($r_sottoclasse->pivot->valutazione_sottoclasse - $utentisclassi[$r_sottoclasse->ID_sottoclasse]['punteggio']);
							}
						}
					}
					$sott = array_add($sott, 'punteggio_tot', 0);
					$esecentisclassi = array_add($esecentisclassi, $ristorante->ID_esercente, $sott);
				}

				foreach ($sottoclassi as $sottoclasse){
					$cont = 0;
					$sott = array();
					foreach ($ristoranti as $ristorante){
						$pos = array();
						$pos = array_add($pos, 'valutazione', $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['valutazione']);
						$sott = array_add($sott, $ristorante->ID_esercente, $pos);
					}
					//dd($sott);
					$sott = array_reverse(array_sort($sott, function($value){
						return $value['valutazione'];
					}),true);
					//print_r($sott);
					foreach ($ristoranti as $ristorante){

						$p = array_search($ristorante->ID_esercente, array_keys($sott));
						$esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['posizione'] = $p+1;
						$esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'] = $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'] / $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['posizione']; 
					}	
				}

				foreach ($ristoranti as $ristorante){
					$punteggio_tot = 1;
					$scarto = 0;
					$cont = 0;
					foreach ($sottoclassi as $sottoclasse){
						$punteggio_tot = $punteggio_tot * $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'];
						if($esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['scarto']>1){
							$cont++;
							$scarto = $scarto + $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['scarto'];
						}
					}
					if ($scarto == 0){
						$media_scarto = 1; 
					}
					else{
						$media_scarto = $scarto / $cont;
					}
					$esecentisclassi[$ristorante->ID_esercente]['punteggio_tot'] = $punteggio_tot / $media_scarto;
				}

				//ORDINAMENTO
				$esecentisclassi = array_reverse(array_sort($esecentisclassi, function($value){
					return $value['punteggio_tot'];
				}),true);
				//RETRIEVE DEI RISTORANTI
				$rist = $ristoranti;
				$esecentisclassi = array_keys($esecentisclassi); 
				$ristoranti = collect([]);
				foreach ($esecentisclassi as $esercente) {
					$app = $rist->where('ID_esercente',$esercente);
					$ristoranti = $ristoranti->merge($app);
				}
				//_______________________________________________________________________________________________
				
				if ($ristoranti->isEmpty()){
					$message="NESSUN RISULTATO CONFORME AI CRITERI RICHIESTI";
				}
				//ALGORITMO FILTRO E RICERCA
				return view('ricerca', compact('id','luogo', 'ristoranti', 'classi', 'questions', 'filtri', 'message'));
    		}
    		//SE NON E' UTENTE LOGGATO MA E' UN GUEST (non ho informazioni sulle sue esigenze)
			//non precompilo i filtri e aspetto che li inserisca lui e rifaccia la ricerca
			{
	    		$l = $luogo;
	    		$luogo = Comune::where('nome_comune',"=", $l)->get()->first();
	    		$ristoranti = DatiEsercente::where('id_comune',"=", $luogo['ID_comune'])->get();
	    		$luogo = $luogo['nome_comune'];
	   			if ($ristoranti->isEmpty()){
					$message="NESSUN RISULTATO CONFORME AI CRITERI RICHIESTI";
				}
	    		return view('ricerca', compact('id','luogo', 'ristoranti', 'classi', 'questions', 'filtri', 'message'));
	    	}
    	}
    	{
    		//DALLA PAGINA RICEVO LUOGO E FILTRI - (RICERCA)
    		//dd("DALLA PAGINA RICEVO LUOGO E FILTRI - (RICERCA)");
    		$l = $luogo;
    		$luogo = Comune::where('nome_comune',"=", $l)->get()->first();
    		$ristoranti = DatiEsercente::where('id_comune',"=", $luogo['ID_comune'])->get();
    		$luogo = $luogo['nome_comune'];

    		$filtri	= $filtri_inseriti;
 			//GUEST_______________________________________________________________________________________
				$utentisclassi = array();
				foreach ($filtri as $filtro)
					foreach ($filtro->sottoclasse()->get()->lists('ID_sottoclasse')->toArray() as $sottoclasse){
						$val = array();
						$val = array_add($val, 'num', 0);
						$val = array_add($val, 'tot', 0);
						$val = array_add($val, 'punteggio', 0);
						$utentisclassi = array_add($utentisclassi, $sottoclasse, $val);
					}


				$sottoclassi = array_keys($utentisclassi);
					foreach ($sottoclassi as $sottoclasse)
					{
					$nDomSC = DB::table('Classi')
					->select(DB::raw('count(*) as num'))
					->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
					->join('UtentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'utentisclassi.id_sottoclasse')
					->rightjoin('FormUtenti', 'formutenti.ID_domanda_utente', '=', 'utentisclassi.id_domanda_utente')
					->where('sottoclassi.id_sottoclasse', '=', $sottoclasse)
					->groupBy('sottoclassi.ID_sottoclasse')
					->get();
					$num = $nDomSC[0]->num;
					$utentisclassi[$sottoclasse]['tot'] = $num;
					}
				foreach ($filtri as $filtro)
					foreach ($filtro->sottoclasse()->get()->lists('ID_sottoclasse')->toArray() as $sottoclasse){
						$utentisclassi[$sottoclasse]['num'] += 1;
					}
				foreach ($sottoclassi as $sottoclasse)
					$utentisclassi[$sottoclasse]['punteggio'] = (integer)($utentisclassi[$sottoclasse]['num'] / $utentisclassi[$sottoclasse]['tot'] *100);
				//______________________________________________________________________________________________


				//RISTORANTI ___________________________________________________________________________________
				$esecentisclassi = array();
				foreach ($ristoranti as $ristorante){
					$r_sottoclassi = $ristorante->sottoclasse()->get();

					$sott = array();
					foreach ($r_sottoclassi as $r_sottoclasse){
						
						foreach ($sottoclassi as $sottoclasse){
								$val = array();
								$val = array_add($val, 'rist', $ristorante->ID_esercente);
								$val = array_add($val, 'valutazione', 0);
								$val = array_add($val, 'punteggio', 1);
								$val = array_add($val, 'posizione', 0);
								$val = array_add($val, 'scarto', 1);

								$sott = array_add($sott, $sottoclasse, $val);

							if($r_sottoclasse->ID_sottoclasse == $sottoclasse){
								$sott[$r_sottoclasse->ID_sottoclasse]['valutazione'] = $r_sottoclasse->pivot->valutazione_sottoclasse;
								$sott[$r_sottoclasse->ID_sottoclasse]['punteggio'] = $r_sottoclasse->pivot->valutazione_sottoclasse / $utentisclassi[$r_sottoclasse->ID_sottoclasse]['punteggio']; //in questa fase è ancora rapporto, poi diventerà punteggio quando divido per la posizione corrente
								if ($sott[$r_sottoclasse->ID_sottoclasse]['punteggio']<1)
									$sott[$r_sottoclasse->ID_sottoclasse]['scarto'] = -1*($r_sottoclasse->pivot->valutazione_sottoclasse - $utentisclassi[$r_sottoclasse->ID_sottoclasse]['punteggio']);
							}
						}
					}
					$sott = array_add($sott, 'punteggio_tot', 0);
					$esecentisclassi = array_add($esecentisclassi, $ristorante->ID_esercente, $sott);
				}

				foreach ($sottoclassi as $sottoclasse){
					$cont = 0;
					$sott = array();
					foreach ($ristoranti as $ristorante){
						$pos = array();
						$pos = array_add($pos, 'valutazione', $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['valutazione']);
						$sott = array_add($sott, $ristorante->ID_esercente, $pos);
					}
					//dd($sott);
					$sott = array_reverse(array_sort($sott, function($value){
						return $value['valutazione'];
					}),true);
					//print_r($sott);
					foreach ($ristoranti as $ristorante){

						$p = array_search($ristorante->ID_esercente, array_keys($sott));
						$esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['posizione'] = $p+1;
						$esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'] = $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'] / $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['posizione']; 
					}	
				}

				foreach ($ristoranti as $ristorante){
					$punteggio_tot = 1;
					$scarto = 0;
					$cont = 0;
					foreach ($sottoclassi as $sottoclasse){
						$punteggio_tot = $punteggio_tot * $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['punteggio'];
						if($esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['scarto']>1){
							$cont++;
							$scarto = $scarto + $esecentisclassi[$ristorante->ID_esercente][$sottoclasse]['scarto'];
						}
					}
					if ($scarto == 0){
						$media_scarto = 1; 
					}
					else{
						$media_scarto = $scarto / $cont;
					}
					$esecentisclassi[$ristorante->ID_esercente]['punteggio_tot'] = $punteggio_tot / $media_scarto;
				}

				//ORDINAMENTO
				$esecentisclassi = array_reverse(array_sort($esecentisclassi, function($value){
					return $value['punteggio_tot'];
				}),true);
				//RETRIEVE DEI RISTORANTI
				$rist = $ristoranti;
				$esecentisclassi = array_keys($esecentisclassi); 
				$ristoranti = collect([]);
				foreach ($esecentisclassi as $esercente) {
					$app = $rist->where('ID_esercente',$esercente);
					$ristoranti = $ristoranti->merge($app);
				}
			//_______________________________________________________________________________________________

    		if ($ristoranti->isEmpty()){
				$message="NESSUN RISULTATO CONFORME AI CRITERI RICHIESTI";
			}
			//ALGORITMO FILTRO E RICERCA
    		return view('ricerca', compact('id','luogo', 'ristoranti', 'classi', 'questions', 'filtri', 'message'));
    	}
       }

    }
}

