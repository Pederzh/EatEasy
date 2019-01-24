<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\DatiEsercente;


class HomeController extends Controller
{
	
	public function index()
	{
		$datiesercente = DatiEsercente::all()->sortBy('created_at');
		//prendo i primi 3
		$ristoranti = collect([$datiesercente[0],$datiesercente[1],$datiesercente[2]]);

		return view('home',compact('ristoranti'));
	}

	public function chiSiamo()
	{
		return view('pages.chisiamo');
	}

	public function contatti()
	{
		return view('pages.contatti');
	}

}
