@extends('layouts.app')

@section('content')
	
	<div class="row">
		<div class="col s12 m4">
			<div class="card hoverable ">
				<div class="card-content">
					<!-- NOME ESERCIZIO -->
					<span class="card-title">{{$datiesercente->nome_esercizio}} ({{$locale->tipo_locale}})</span>
					<p> 
						<!-- INDIRIZZO -->
						<table>
							<thead>
								<tr>
									<th data-field="email">Indirizzo</th>
									<th data-field="password">Numero Civico</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$datiesercente->indirizzo}}</td>
									<td>{{$datiesercente->numero_civico}}</td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th data-field="name">Comune</th>
									<th data-field="name">Area</th>
								</tr>
							</thead>
							<!-- INDIRIZZO, N CIVICO, COMUNE E AREA -->
							<tbody>
								<tr>
									<td>{{$comune->nome_comune}}</td>
									<td>{{$area->area}}</td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th data-field="name">Telefono</th>
									<th data-field="name">Sito Web</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$datiesercente->telefono}}</td>
									<td><a href="{{$datiesercente->web_url}}">{{$datiesercente->web_url}} </a></td>
								</tr>
							</tbody>
						</table>
					</p>
				</div>
			</div>
		</div>
		<!-- FOTO -->
		<div class="col s12 m8">
			<div class="card hoverable ">
				<div class="card-content ">
					<span class="card-title">Foto</span>
					<p>
						<!-- IMMAGINI -->
		                <div class="carousel">
		                    @for ($i = 1; $i <= count($immagini); $i++)
		                        <img class="carousel-item responsice-img" src="{{ url($immagini[$i]) }}">
		                    @endfor
		                </div>
					</p>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col s12 m6">
			<div class="card hoverable ">
				<div class="card-content ">
					<span class="card-title">Informazioni</span>

					<p class="flow-text">
						<table>
							<thead>
								<tr>
									<th data-field="name">Descrizione</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$datiesercente->descrizione}}</td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th data-field="name">Orari e giorni d''apertura</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$datiesercente->info_orari}}</td>
								</tr>
							</tbody>
						</table>
					</p>
				</div>
			</div>
        	<!-- PUNTEGGI -->
        	<div class="card hoverable ">
				<div class="card-content ">
					<span class="card-title">Punteggi</span>
					<p>
						<table>
							<thead>
								<tr>
									<th data-field="name" value="Arrivals">Arrivals</th>
									<th data-field="name" value="Access">Access</th>
									<th data-field="name" value="Food">Food</th>
								</tr>
							</thead>
							<tbody>
									<tr>
										<td>{{$arrivals}}</td>
										<td>{{$access}}</td>
										<td>{{$food}}</td>
									</tr>
							</tbody>
							<thead>
								<tr>
									<th data-field="name" value="Baby">Baby</th>
									<th data-field="name" value="Technology">Technology</th>
									<th data-field="name" value="Green">Green</th>
								</tr>
							</thead>
							<tbody>
									<tr>
										<td>{{$baby}}</td>
										<td>{{$technology}}</td>
										<td>{{$green}}</td>
									</tr>
							</tbody>
						</table>
					</p>
				</div>
			</div>
		</div>
		<!--GRAFICO DEI PUNTEGGI-->
		<div class="col s12 m6">
			<div class="card hoverable">
				<div class="card-content">
					<canvas id="GraficoPunteggio" width="400" height="400"></canvas>
				</div>
			</div>
		</div>
	</div>	

	<!-- SERVIZI -->
	<div class="row">
		<div class="col s12">
			<div class="card hoverable ">
				<div class="card-content ">
					<ul class="collapsible" data-collapsible="accordion">
    					<li>
    						<div class="collapsible-header"><i class="material-icons">filter_drama</i>Servizi</div>
							<div class="collapsible-body">
								<p>
									<table>
										<tbody>
											@foreach($formesercente as $servizio)
											<tr>
												<td>{{$servizio->domanda}} <i class="material-icons right">done</i> </td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</p>
							</div>
    					</li>
    				</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- INPUT NASCOSTI PER PRENDERE I DATI DEL GRAFICO -->
	<input hidden id="Arrivals" value="{{$arrivals}}">
	<input hidden id="Access" value="{{$access}}">
	<input hidden id="Food" value="{{$food}}">
	<input hidden id="Baby" value="{{$baby}}">
	<input hidden id="Technology" value="{{$technology}}">
	<input hidden id="Green" value="{{$green}}">

@endsection