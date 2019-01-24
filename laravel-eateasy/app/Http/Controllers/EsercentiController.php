<?php

namespace App\Http\Controllers;

use Request;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Auth; 		//importo la classe Auth per accedere allo user loggato
use App\User;	//classe User 
use App\DatiEsercente;	//classe DatiEsercente
use App\Metratura;
use App\Comune;
use App\TipoLocale;
use App\AreaUrbana;
use App\EsercenteServizio;
use App\Sottoclasse;
use App\Classe;
use DB;

use Storage;	//per salvare le immagini

class EsercentiController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth',['except' =>  ['storeCompleteRegistration', 'autocomplete', 'showRestaurant']]);
	}

	/*Mostra la pagina per il completam
	ento dei dati e quindi della registrazione
	*/
	public function showCompleteRegistration()
	{
		// fetch dell'id
		$id = Auth::user()->id;
		Auth::logout(Auth::user());
		
		// metrature
		$metratura = Metratura::all();
		
		// comuni
		$comune = Comune::all();
		
		// tipolocale
		$tipolocale = TipoLocale::all();
		
		// areaurbana
		$areaurbana = AreaUrbana::all();

		return view('esercenti.complete',compact('id','metratura','comune','areaurbana','tipolocale'));
	}

	/**
	 * Salva i dati dell'esercente nel database
	 */
	public function storeCompleteRegistration(){
		// richiede i dati dalla pagina
		$input = Request::all();
		
		//------------------------------------------------
		//SALVATAGGIO IMMAGINI
		$files = $input['percorso_img'];
		$percorso = [];
		$nome = [];

		$cartella = ''.$input['ID_esercente'].'/';
		//creo la cartella - ha il nome dell'ID user
		Storage::makeDirectory($cartella);
		
		$cont = 0;
		foreach ($files as $file) {
			//metto nell'array nome i nomi dei file
			$cont++;
			$nome[$cont] = '' . $cartella . $cont . '.jpg';
			//metto nell'array percorso i percorsi originari dei file
			$percorso[$cont] = $file->getPathName();

			//chmod($percorso[$cont], 0777);
			//salvo il file, primo parametro=nome, secondo=percorso

		Storage::put(
				$nome[$cont],              //nome
				file_get_contents($percorso[$cont]) //percorso originale
			);
		}
		//-------------------------------------------------------------
		 //ritrovo id comune 
		//************** sSE NON ESISTE???
		$comune =  Comune::where("nome_comune", "=", $input['id_comune'] )->get();
		$input['id_comune'] = $comune[0]["ID_comune"] ;
		
		//inserisco nel campo percorso_img il nome della cartella dove sono inserite le immagi
		$input['percorso_img'] = $cartella;

		// esegue la insert
		DatiEsercente::create($input); 
		
		// login dello user
		$user = User::find($input['ID_esercente']);
		Auth::login($user);
		
		// redirect
		return redirect('/questionesercente');
	}

	public function showQuestion(){
		//query prendo le tabelle che mi servono
		//se uso le join devo accedere alla tabella direttamente
		$classi = DB::table('Classi')->get();

		$questions = DB::table('Classi')
			->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
			->join('EsercentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'esercentisclassi.id_sottoclasse')
			->rightjoin('FormEsercenti', 'formesercenti.ID_domanda_esercente', '=', 'esercentisclassi.id_domanda_esercente')
			->groupBy('FormEsercenti.ID_domanda_esercente')
			->get();
		   
		//$questions = FormUtente::with(['UtentiSclasse'],[])->get();
	   // $questions = FormUtente::all();
		return view('esercenti.question', compact('questions','classi'));;
	}

	public function storeQuestion(Request $request)
	{
		$id = Auth::user()->id;
		$ristorante = DatiEsercente::find($id);
		$input = Request::all();
		foreach($input as $key=>$val)
		{
			$arr = array();
		   // print_r($arr);
			if ($val == 'on')
			{
				//$arr = array_add($arr,'id_esercente', $id);
				//$arr = array_add($arr,'id_domanda', $key); //['id_utente' => $id], ['id_domanda' => $key]);
				//$arr = array_add($arr,'valutazione', '1'); //DA MODIFICARE LA VALUTAZIONE
				$ristorante->FormEsercente()->attach($key, ['valutazione' => 1]);

			}
		}
		return redirect('/punteggio');
	}

	public function storeScore()
	{
		//DATU NECESSARI
		$id = Auth::user()->id; //id dell'esercente
		$ristorante = DatiEsercente::find($id);
		$sottoclassi = Sottoclasse::all();
		$punteggi = array();
		$classi = Classe::all();

		//PREPARAZIONE VARIABILI PER PUNTEGGI SOTTOCLASSE
		foreach ($sottoclassi as $sottoclasse)
		{
			$val = array();

			if ($sottoclasse->ID_sottoclasse!=0)
			{
				$val = array_add($val, 'daContare', 0);
				$val = array_add($val, 'tot', 0);
				$punteggi = array_add($punteggi, $sottoclasse->nome_sottoclasse, $val);
			}
		}
		$nDomSC = DB::table('Classi')
			->select(DB::raw('count(*) as num, sottoclassi.nome_sottoclasse'))
			->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
			->join('EsercentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'esercentisclassi.id_sottoclasse')
			->rightjoin('FormEsercenti', 'formesercenti.ID_domanda_esercente', '=', 'esercentisclassi.id_domanda_esercente')
			->groupBy('sottoclassi.ID_sottoclasse')
			->get();
		foreach ($nDomSC as $ndom)
		{
			$punteggi[$ndom->nome_sottoclasse]['tot'] = $ndom->num;
			
		}

		$class = array();
		foreach ($classi as $classe)
		{
			$val = array();
			if ($classe->ID_classe!=0)
			{
				$val = array_add($val, 'daContare', 0);
				$val = array_add($val, 'tot', 0);
				$class = array_add($class, $classe->nome_classe, $val);
			}
		}
		$nDomC = DB::table('Classi')
			->select(DB::raw('count(*) as num, classi.nome_classe'))
			->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
			->join('EsercentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'esercentisclassi.id_sottoclasse')
			->rightjoin('FormEsercenti', 'formesercenti.ID_domanda_esercente', '=', 'esercentisclassi.id_domanda_esercente')
			->groupBy('classi.ID_classe')
			->get();
		foreach ($nDomC as $ndom)
		{
			$class[$ndom->nome_classe]['tot'] = $ndom->num;
		}

		$questions = DB::table('Classi')
			->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
			->join('EsercentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'esercentisclassi.id_sottoclasse')
			->rightjoin('FormEsercenti', 'formesercenti.ID_domanda_esercente', '=', 'esercentisclassi.id_domanda_esercente')
			->rightjoin('esercentiservizi', 'formesercenti.ID_domanda_esercente', '=', 'esercentiservizi.id_domanda')
			->where('esercentiservizi.valutazione','1')
			->where('esercentiservizi.id_esercente', $id)
			->get();
			//dd($questions);
			foreach ($questions as $question)
			{
				$punteggi[$question->nome_sottoclasse]['daContare'] += 1;
				$class[$question->nome_classe]['daContare'] += 1 ;
				$arrs = array();
				$arrs = array_add($arrs, 'id_sottoclasse', $question->id_sottoclasse);
				$arrc = array();
				$arrc = array_add($arrc, 'id_classe', $question->id_classe);
				$controllas = $ristorante->sottoclasse()->where('EsercentiSottoclassi.id_sottoclasse','=',$question->id_sottoclasse)->get();
				$controllac = $ristorante->classe()->where('EsercentiClassi.id_classe','=',$question->id_classe)->get();
				
				//AGGIORNO PUNTEGGI SOTTOCLASSI
				if (!$controllas->isEmpty()) //in caso esista già la row allora aggiorno il contenuto
				{
					$ristorante->sottoclasse()->where('EsercentiSottoclassi.id_sottoclasse','=',$question->id_sottoclasse)->update(['valutazione_sottoclasse'=>($punteggi[$question->nome_sottoclasse]['daContare']/$punteggi[$question->nome_sottoclasse]['tot'])*100]);
				}
				else//inserisco nuova row
				{
					$ristorante->sottoclasse()->attach($arrs, ['valutazione_sottoclasse'=>($punteggi[$question->nome_sottoclasse]['daContare']/$punteggi[$question->nome_sottoclasse]['tot'])*100]);
					//DB::insert('insert into EsercentiSottoclassi (id_esercente, id_sottoclasse, valutazione_sottoclasse) values (?,?,?)', [$id, $question->id_sottoclasse, $punteggi[$question->nome_sottoclasse]]);
				}

				//AGGIORNO PUNTEGGI CLASSI
				if (!$controllac->isEmpty()) //in caso esista già la row allora aggiorno il contenuto
				{
					$ristorante->classe()->where('EsercentiClassi.id_classe','=',$question->id_classe)->update(['valutazione_classe'=>($class[$question->nome_classe]['daContare']/$class[$question->nome_classe]['tot'])*100]);
				}
				else//inserisco nuova row
				{
					$ristorante->classe()->attach($arrc, ['valutazione_classe'=>($class[$question->nome_classe]['daContare']/$class[$question->nome_classe]['tot'])*100]);
					//DB::insert('insert into EsercentiSottoclassi (id_esercente, id_sottoclasse, valutazione_sottoclasse) values (?,?,?)', [$id, $question->id_sottoclasse, $punteggi[$question->nome_sottoclasse]]);
				}
			}
	   return redirect('/reservedarea');
	}
	
	/* mostra la pagina del ristorante */
	public function showRestaurant($id)
	{
		$esercente = User::findOrFail($id);
		$datiesercente = DatiEsercente::findOrFail($id);

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
			$path = '' . $id . '/' . $count . '.jpg'; 
			if (Storage::exists($path))
			{
				$immagini[$count] = 'getImg/' . $id . '/' . $count . '.jpg';
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
		return view('esercenti.show',compact('esercente','datiesercente','comune','area','locale','metratura','formesercente','immagini','arrivals','access','food','baby','technology','green','chart'));
	}

	//AUTOCOMPLETE PER LA RICERCA DEL COMUNE
	public function autocomplete(){
		$string=Str::lower(Input::get('term'));
		//check con il database
		$data = Comune::where('nome_comune', 'LIKE', $string.'%')->groupBy('nome_comune')->orderBy('nome_comune')->take(10)->get(); 
		foreach ($data as $city){
			$array[] = array('value' => $city->nome_comune);
		}
		//return dell'array
		return Response::json($array);
	}
}