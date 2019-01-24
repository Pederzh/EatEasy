@extends('layouts.app')

@section('content')
	<div class="section">
		<div class="row">
			<div class="col s8 offset-s2 z-depth-5">
				<h2 class="header">COMPLETA IL TUO PROFILO </h2>
				<div class="container">
					<form class="section" method="post" action="{{ url('/esercente/salvaCompleteRegistration') }}" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">

							<!-- HIDDEN FIELD ID_esercente -->
							<div class="input-field col s6" hidden>
								<input id="ID_esercente" name="ID_esercente" type="text" class="validate" value={{$id}}>
							</div>

							<!-- NOME ESERCENTE -->
							<div class="row">
								<div class="input-field col s6">
									<i class="material-icons prefix">perm_identity</i>
									<input id="nome_esercente" name="nome_esercente" type="text" class="validate">
									<label for="nome_esercente">Nome esercente</label>
								</div>

							<!-- COGNOME ESERCENTE -->
								<div class="input-field col s6">
									<input id="cognome_esercente" name="cognome_esercente" type="text" class="validate">
									<label for="cognome_esercente">Cognome esercente</label>
								</div>
							</div>

							<!-- NOME ESERCIZIO -->
							<div class="row">
								<div class="input-field col s12">
									<i class="material-icons prefix">label</i>
									<input id="nome_esercizio" name="nome_esercizio" type="text" class="validate">
									<label for="nome_esercizio">Nome Esercizio</label>
								</div>
							</div>

    						<!-- TELEFONO e SITO WEB -->
							<div class="row">
								<div class="input-field col s6">
									<i class="material-icons prefix">phone</i>
									<input id="telefono" name="telefono" type="tel" class="validate">
									<label for="telefono">Telefono</label>
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix">language</i>
									<input id="web_url" name="web_url" type="text">
									<label for="web_url">Sito Web</label>
								</div>
							</div>
							
							<!-- PARTITA IVA -->
							<div class="row">
								<div class="input-field col s12">
									<i class="material-icons prefix">work</i>
									<input id="partita_iva" name="partita_iva" type="text" class="required">
									<label for="partita_iva" data-error="wrong" data-success="right">Partita IVA</label>
								</div>
							</div>

							<!-- METRATURA e TIPO LOCALE -->
							<div class="row">
								<div class="input-field col s4">
									<select id="id_tipo_locale" name="id_tipo_locale">
										@foreach($tipolocale as $opt)
											<option value="{{ $opt->ID_tipo_locale}}">{{ $opt->tipo_locale}}</option>
										@endforeach
									</select>
									<label>Tipo di locale</label>
								</div>
								<div class="input-field col s4">
									<select id="id_metratura" name="id_metratura">
									@foreach($metratura as $opt)
											<option value="{{ $opt->ID_metratura}}">{{ $opt->fascia_metratura}}</option>
									@endforeach
									</select>
									<label>Fascia di metratura</label>
								</div>
								<div class="input-field col s4">
									<input id="metratura" name="metratura" type="text">
									<label for="metratura">Metratura esatta</label>
								</div>
							</div>

							<!-- DESCRIZIONE -->
							<div class="row">
								<div class="input-field col s12">
									<i class="material-icons prefix">info_outline</i>
									<textarea id="descrizione" name="descrizione" class="materialize-textarea" length="512"></textarea>
									<label for="descrizione">Descrizione</label>
								</div>
							</div>

							<!-- ORARI e GIORNI APERTURA -->
							<div class="row">
								<div class="input-field col s12">
									<i class="material-icons prefix">schedule</i>
									<textarea placeholder="EX. Lunedì-Venerdì 11:00 - 14.30" id="info_orari" name="info_orari" class="materialize-textarea" length="512"></textarea>
									<label for="info_orari">Giorni e orari di apertura</label>
								</div>
							</div>

							<!-- IMMAGINI RISTORANTE -->
							<div class="row">
								<div class="file-field input-field">
									<div class="btn">
										<span>File</span>
										<input type="file" id="percorso_img[]" name="percorso_img[]" multiple>
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text" placeholder="Scegli le immagini da caricare">
									</div>
								</div>
    						</div>

							<div class="divider"> </div>

							<!-- Inseriti da noi in base alle api di GMaps -->
							<div class="row">
								<h5> Localizzazione </h5>
							</div>

							<!-- OOOOOOOOOOOOOOOOOOOOOOOOOOO -->
							<!--  LI PRENDEREMO DALLA MAPPA  -->
							<!-- OOOOOOOOOOOOOOOOOOOOOOOOOOO -->
							<div class="row" hidden>
								<div class="input-field col s6">
									<input id="latitudine" name="latitudine" type="text" class="validate">
									<label for="latitudine">Latitudine</label>
								</div>
								<div class="input-field col s6">
									<input id="longitudine" name="longitudine" type="text" class="validate">
									<label for="longitudine">Longitudine</label>
								</div>
							</div>

							<!-- INDIRIZZO e N.CIVICO e COMUNE -->
							<div class="row">
								<div class="input-field col s6">
									<i class="material-icons prefix">location_on</i>
									<input id="indirizzo" name="indirizzo" type="text" class="validate">
									<label for="indirizzo">Indirizzo</label>
								</div>
								<div class="input-field col s2">
									<input id="numero_civico" name="numero_civico" type="text" class="validate">
									<label for="numero_civico">N. Civico</label>
								</div>
                                <div class="input-field col s4">
									    <input id="comune" name="id_comune" type="text" class="ui-autocomplete-input">
                                    <label for="comune">Comune</label>	
								</div>
							</div>

							<!-- AREA -->
							<div class="row">
								<div class="input-field col s12">
									<select id="id_area" name="id_area">
										@foreach($areaurbana as $opt)
											<option value="{{ $opt->ID_area}}">{{ $opt->area}}</option>
										@endforeach
									</select>
									<label>Area in cui si trova</label>
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