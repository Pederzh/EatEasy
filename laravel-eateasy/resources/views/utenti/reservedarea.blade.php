@extends('layouts.app')

@section('content')
	<div class="row">
		<!-- IMMAGINE DEL PROFILO -->
		<div class="col s12 m3">
			<div class="card hoverable">
				<div class="card-content ">
				<img class="circle responsive-img" src="{{ url($immagine) }}">
				</div>
				<div class="card-action">
					<a href="#">Cambia</a>
				</div>
			</div>
		</div>

		<div class="col s12 m9">
			<div class="card hoverable">
				<div class="card-content ">
					<!-- NOME E COGNOME -->
					<span class="card-title">{{$datiutente->nome}} {{$datiutente->cognome}}</span>
					<p> 
						<!-- EMAIL E PASSWORD --> <!-- USERNAME -->
						<table>
							<thead>
								<tr>
									<th data-field="email">Email</th>
									<th data-field="password">Password</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$utente->email}}</td>
									<td> *** </td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th data-field="name">Username</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$datiutente->username}}</td>
									<td> </td>
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
				<div class="card-content">
					<span class="card-title">Informazioni</span>
					<p>
						<table>
							<thead>
								<tr>
									<th data-field="name">Comune</th>
									<th data-field="name">Lingua</th>
									<th data-field="name">Data di nascita</th>
									<th data-field="name">Sesso</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$comune->nome_comune}}</td>
									<td>{{$lingua->lingua}}</td>
									<td>{{$datiutente->data_nascita}}</td>
									<td>{{$datiutente->sesso}}</td>
								</tr>
							</tbody>
						</table>
					</p>
				</div>
			</div>
		</div>
	</div>

	<!-- ESIGENZE -->
	<div class="row">
		<div class="col s12">
			<div class="card hoverable ">
				<div class="card-content">
					<span class="card-title">Esigenze</span>
					<p>
						<table>
							<thead>
								<tr>
									<th data-field="name">Descrizione</th>
								</tr>
							</thead>
							<tbody>
									@foreach($formutente as $esigenza)
									<tr>
										<td>{{$esigenza->domanda}}</td>
									</tr>
									@endforeach
							</tbody>
						</table>
					</p>
				</div>
			</div>
		</div>
	</div>
@endsection