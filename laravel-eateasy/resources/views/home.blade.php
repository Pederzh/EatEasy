@extends('layouts.app')

@section('fullwidth')

	<!-- SLIDER -->
	<div class="slider" >
		
		<ul class="slides" >
			<li>
				<img src="{{asset('img/slider1.jpg')}}">
				<div class="caption center-align">
					<form action="{{ url('/ricerca') }}"  class="search-wrapper cf">
						<input id="luogo" name="luogo" type="text" placeholder="Ricerca luogo..." required="">
						<button type="submit">  <i class="material-icons">search</i> </button>
					</form>
				</div>
			</li>
		</ul>
	</div>
	<!-- SLIDER END -->

@endsection

@section('content')

	<div class="row">
		<h2 class="header center">Ultimi ristoranti aggiunti</h2>
	</div>
	<div class="row">
			@foreach($ristoranti as $ristorante)
				<div class="col s12 m4">
					<div class="card">
						<div class="card-image">
							<img src="{{url('getImg/' . $ristorante->ID_esercente,'1.jpg')}}">
							<span class="card-title"> </span>
						</div>
						<div class="card-content">
							<p class="truncate">{{$ristorante->descrizione}}</p>
						</div>
						<div class="card-action">
							<a href="{{url('ristorante',$ristorante->ID_esercente)}}">{{$ristorante->nome_esercizio}}</a>
						</div>
					</div>
				</div>
			@endforeach
	</div>

	<div class="row">
		<div class="col s12 m7">
			<div class="card hoverable">
				<div class="card-content ">
					<div class="card-title">Eateasy</div>
						EatEasy è un progetto nato dalla collaborazione con delle ragazze di Genova al quinto anno di Università, alla facoltà di architettura. Il loro obiettivo è quello di proporre alle attività commerciali presenti in Italia delle modifiche a livello strutturale, che permettano di aumentare il livello di accessibilità. Da questo il bisogno di una piattaforma che possa raccogliere, organizzare e classificare sia le possibili esigenze particolari dei clienti, sia i servizi e le soluzioni che offrono gli esercenti.
				</div>
			</div>
		</div>
		<div class="col s12 m5">
			<div class="card  hoverable">
				<div class="card-content ">
					<div class="card-title">News</div>
						<div class="collection">
				        	<a href="www.laravel.com" class="collection-item">Laravel</a>
				        	<a href="www.materializecss.com/" class="collection-item">Materialize</a>
				        	<a href="www.mysql.it" class="collection-item">MySql</a>
				      	</div>
				</div>
			</div>
		</div>

	</div>
@endsection