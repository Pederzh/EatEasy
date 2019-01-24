@extends('layouts.app')

@section('content')
	<div class="section">
		<div class="row">
			<div class="col s8 offset-s2 z-depth-5">
				<h2 class="header">COMPLETA IL TUO PROFILO </h2>
				<div class="container">
					<form class="section" method="post" action="{{ url('/utente/salvaCompleteRegistration') }}" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
							<!-- HIDDEN FIELD ID_utente e livello-->
							<div class="input-field col s6" hidden>
								<input id="ID_utente" name="ID_utente" type="text" class="validate" value={{$id}}>
							</div>
							<div class="input-field col s6" hidden>
								<input id="id_livello" name="id_livello" type="text" class="validate" value=1>
							</div>

							<!-- NOME E COGNOME UTENTE -->
							<div class="row">
								<div class="input-field col s6">
									<i class="material-icons prefix">perm_identity</i>
									<input id="nome" name="nome" type="text" class="validate">
									<label for="nome">Nome</label>
								</div>
								<div class="input-field col s6">
									<!-- <i class="material-icons prefix"></i> -->
									<input id="cognome" name="cognome" type="text" class="validate">
									<label for="cognome">Cognome</label>
								</div>
							</div>

							<!-- USERNAME -->
							<div class="row">
								<div class="input-field col s12">
									<i class="material-icons prefix">label</i>
									<input id="username" name="username" length="32" type="text" class="validate">
									<label for="username">Nome utente</label>
								</div>
							</div>
							
							<!-- COMUNE E LINGUA -->
							<div class="row">
								<div class="input-field col s6">
										<i class="material-icons prefix">location_on</i>
									    <input id="comune" name="id_comune" type="text" class="ui-autocomplete-input">
          								<label for="comune">Comune</label>
								</div>			
								<div class="input-field col s6">
									<select id="id_lingua" name="id_lingua">
										@foreach($lingua as $opt)
											<option value="{{ $opt->ID_lingua}}">{{ $opt->lingua}}</option>
										@endforeach
									</select>
									<label>Lingua</label>
								</div>
							</div>

							<!-- DATA DI NASCITA E SESSO -->
							<div class="row">
								<div class="input-field col s6">
									<i class="material-icons prefix">today</i>
									<input id="data_nascita" name="data_nascita" type="date" class="datepicker">
									<label for="data_nascita">Data di nascita</label>
								</div>
								<div class="input-field col s6">
									<select id="sesso" name="sesso">
										<option value="" disabled selected>Scegli..</option>
										<option value="maschio">Maschio</option>
										<option value="femmina">Femmina</option>
										<option value="altro">Altro</option>
									</select>
									<label>Sesso</label>
								</div>
							</div>

							<!-- IMMAGINE UTENTE -->
							<div class="row">
								<div class="file-field input-field">
									<div class="btn">
										<span>File</span>
										<input type="file" id="percorso_img[]" name="percorso_img[]">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text" placeholder="Scegli la tua immagine del profilo">
									</div>
								</div>
    						</div>

    						<div class="divider"> </div>

							<div class="row">
								<div class="input-field col s12">
									Desidero iscrevermi alla newsletter e ricevere informazioni riguardanti attività ed eventi di Eateasy.<br>
									<input type="checkbox" class="filled-in" id="consenso_trattamento_dati" name="consenso_trattamento_dati"/>
									<label for="consenso_trattamento_dati">Acconsento</label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									Consento al trattamento dei dati sensibili secondo le normative 196/2003 Art. 13 - informativa sulla privacy e 196/2003 Art. 23 - consenso al trattamento dei dati<br>
									<input type="checkbox" class="filled-in" id="newsletter" name="newsletter"/>
									<label for="newsletter">Acconsento</label>
								</div>
							</div>

							<!-- SUBMIT -->
							<div class="row">
								<div class="input-field col s12 right-align">
									<button class="btn waves-effect waves-light" type="submit" name="action">Completa<i class="material-icons right">send</i></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
@endsection