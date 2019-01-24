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
use App\DatiUtente;
use App\Lingua;
use App\Comune;
use App\FormUtente;
use App\UtenteSclasse;
use App\Sottoclassi;
use DB;

use Storage; //per salvare le immagini

class UtentiController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth',['except' =>  ['storeCompleteRegistration', 'autocomplete']]);
	}

	/**
	 * Mostra la pagina per il completamento dei dati e quindi della registrazione
	 */
	public function showCompleteRegistration()
	{
		// fetch dell'id
		$id = Auth::user()->id;
		Auth::logout(Auth::user());
		
		// comuni
		$comune = Comune::all();
		
		// lingua
		$lingua = Lingua::all();

		return view('utenti.complete', compact('id','comune','lingua'));
	}
	
	/**
	 * Salva i dati dell'utente nel database
	 */
	public function storeCompleteRegistration(){
		
		// richiede i dati dalla pagina
		$input = Request::all();

		//------------------------------------------------
		//SALVATAGGIO IMMAGINI
		$files = $input['percorso_img'];
		$percorso = [];
		$nome = [];

		$cartella = ''.$input['ID_utente'].'/';
		//creo la cartella - ha il nome dell'ID user
		Storage::makeDirectory($cartella);
		
		$cont=0;
		foreach ($files as $file) {
			$cont++;
			//metto nell'array nome i nomi dei file
			$nome[$cont] = ''.$cartella.'avatar.jpg';

			//metto nell'array percorso i percorsi originari dei file
			$percorso[$cont] = $file->getPathName();

			//chmod($percorso[$cont], 0777);
			//salvo il file, primo parametro=nome, secondo=percorso
			Storage::put(
				$nome[$cont],              //nome
				file_get_contents($percorso[$cont]) //percorso originale
			);
		}

		//inserisco nel campo percorso_img il nome della cartella dove sono inserite le immagi
		$input['percorso_img'] = $cartella;
		
		//-------------------------------------------------------------
        //conversione della data
        $input['data_nascita']=Carbon::parse($input['data_nascita'], 'Europe/Rome')->format('Y-m-d');
        //ritrovo id comune 
        //************** sSE NON ESISTE???
        $comune =  Comune::where("nome_comune", "=", $input['id_comune'] )->get();
		$input['id_comune'] = $comune[0]["ID_comune"] ;

		// esegue la insert
		DatiUtente::create($input);
		
		
		// login dello user
		$user = User::find($input['ID_utente']);
		Auth::login($user);
		
		// redirect
		return redirect('/questionutente');
	}

	public function showQuestion(){


		//query prendo le tabelle che mi servono
		//se uso le join devo accedere alla tabella direttamente
		$classi = DB::table('Classi')->get();

		$questions = DB::table('Classi')
            ->join('Sottoclassi', 'sottoclassi.id_classe', '=', 'classi.ID_classe')
            ->join('UtentiSClassi', 'sottoclassi.ID_sottoclasse', '=', 'utentisclassi.id_sottoclasse')
            ->rightjoin('FormUtenti', 'formutenti.ID_domanda_utente', '=', 'utentisclassi.id_domanda_utente')
            ->groupBy('FormUtenti.ID_domanda_utente')
            ->get();
           
        //$questions = FormUtente::with(['UtentiSclasse'],[])->get();
        //$questions = FormUtente::all();
        return view('utenti.question', compact('questions','classi'));;
	}
	

	public function storeQuestion(Request $request)
	{
  		$id = Auth::user()->id;
  		$utente = DatiUtente::find($id);
  		$input = Request::all();
  		foreach($input as $key=>$val)
  		{
   			$arr = array();
           // print_r($arr);
   			if ($val == 'on')
   			{
                //$arr = array_add($arr,'id_domanda', $key); //['id_utente' => $id], ['id_domanda' => $key]);
    			$utente->FormUtente()->attach($key);
   			}
  		}
  		return redirect('/');
 	}
	//___________________________________________________________________
	//DA FARE
	//___________________________________________________________________

	//PAGINA EDITING DEL PROFILO (UPDATE)
	public function edit(/*Inserire l'ID ristorante da mostrare*/){

		//in questa variabile inserisco l'ID (preso dal model DatiUtente) che passerò alla view
		//$utente = DatiUtente::findOrFail($id);

		return view('utenti.edit', compact('utente'));

	}
	//PAGINA RISERVATA PROFILO - MOSTRA SOLTANTO (SELECT)
	public function show(/*Inserire l'ID ristorante da mostrare*/){

		//in questa variabile inserisco l'ID (preso dal model DatiUtente) che passerò alla view
		//$utente = DatiUtente::findOrFail($id);

		return view('utenti.show', compact('utente'));
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
