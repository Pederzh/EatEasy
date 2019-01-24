@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col s12 m5">
			<div class="card hoverable ">
				<div class="card-content">
					<!-- NOME E COGNOME -->
					<span class="card-title">{{$datiesercente->nome_esercente}} {{$datiesercente->cognome_esercente}}</span>
					<p> 
						<!-- EMAIL E PASSWORD -->
						<table>
							<thead>
								<tr>
									<th data-field="email">Email</th>
									<th data-field="password">Password</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$esercente->email}}</td>
									<td> *** </td>
								</tr>
							</tbody>
                                    <thead>
                                    <tr>
                                        <th data-field="name">Indirizzo</th>
                                        <th data-field="name">Numero civico</th>
                                    </tr>
                                </thead>
                            	<!-- INDIRIZZO, N CIVICO, COMUNE E AREA -->
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
                                <tbody>
                                    <tr>
                                        <td>{{$comune->nome_comune}}</td>
                                        <td>{{$area->area}}</td>
                                    </tr>
                                </tbody>
						</table>
					</p>
				</div>
				<div class="card-action">
					<a href="#">Cambia</a>
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
        <div class="col s12 m7">
			<div class="card hoverable">
				<div class="card-content">
						<canvas id="GraficoPunteggio" width="400" height="400"></canvas>
				</div>
			</div>
		</div>
    </div>
	<div class="row">
		<div class="col s12 m12">
			<div class="card hoverable ">
				<div class="card-content ">
					<span class="card-title">Informazioni</span>
					<!-- NOME ESERCIZIO, TELEFONO, SITO WEB-->
					<p class="flow-text">
						<table>
							<thead>
								<tr>
									<th data-field="name">Nome esercizio</th>
									<th data-field="name">Telefono</th>
                                   	<th data-field="name">Sito Web</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$datiesercente->nome_esercizio}}</td>
									<td>{{$datiesercente->telefono}}</td>
                                    <td>{{$datiesercente->web_url}}</td>
                                    
								</tr>
							</tbody>
                            	<!-- PARTITA IVA, FASCIA, METRATURA -->
							<thead>
								<tr>
									<th data-field="name">Partita IVA</th>
                                    <th data-field="name">Fascia metratura</th>
									<th data-field="name">Metratura esatta</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									
									<td>{{$datiesercente->partita_iva}}</td>
                                    <td>{{$metratura->fascia_metratura}}</td>
									<td>{{$datiesercente->metratura}}</td>
								</tr>
							</tbody>
                            <!-- TIPO LOCALE, DESCRIZIONE, ORARI APERTURA -->
                            	<thead>
								<tr>
									<th data-field="name">Tipo locale</th>
                                    <th data-field="name">Descrizione</th>
									<th data-field="name">Orari e giorni d''apertura</th>
								</tr>
							</thead>
							<tbody>
								<tr>
								
									<td>{{$locale->tipo_locale}}</td>
                                    <td>{{$datiesercente->descrizione}}</td>
									<td>{{$datiesercente->info_orari}}</td>
								</tr>
							</tbody>
						</table>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
       <div class="col s12">
			<div class="card hoverable ">
                <!-- IMMAGINI -->
                <div class="carousel">
                    @for ($i = 1; $i <= count($immagini); $i++)
                        <img class="carousel-item responsive-img" src="{{ url($immagini[$i]) }}">
                    @endfor
                </div>
           </div>
        </div>
    </div>
	

	<!-- SERVIZI -->
	<div class="row">
		<div class="col s12">
			<div class="card hoverable ">
				<div class="card-content ">
					<span class="card-title">Servizi</span>
					<p>
						<table>
							<thead>
								<tr>
									<th data-field="name">Descrizione</th>
								</tr>
							</thead>
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

	<!-- INPUT NASCOSTI PER PRENDERE I DATI DEL GRAFICO DELLA MEDIA-->
	<input hidden id="Arrivals2" value="{{$arrivals}}">
	<input hidden id="Access2" value="{{$access}}">
	<input hidden id="Food2" value="{{$food}}">
	<input hidden id="Baby2" value="{{$baby}}">
	<input hidden id="Technology2" value="{{$technology}}">
	<input hidden id="Green2" value="{{$green}}">
@endsection