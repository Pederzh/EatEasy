@extends('layouts.app')

@section('content')
<div class="section">
		<div class="row">
			<div class="col s8 offset-s2 z-depth-5">
				<h2 class="header">COLLABORA CON NOI</h2>
					<div class="row">
						<form class="col s12" method="POST" action="{{ url('/esercente/storeQuestion') }}" enctype="multipart/form-data">
							{!! csrf_field() !!}
			 					<ul class="collapsible" data-collapsible="accordion">
			 						 @foreach($classi as $classe)
								    @if ($classe->ID_classe!=0)
								    <li>
									  <div class="collapsible-header">{{$classe->nome_classe}}</div>
								      	<div class="collapsible-body">
								     		<div class="row">
								     			<div class="col s12">
				        							<table class="highlight">
				        							@foreach($questions as $question)
												      			@if ($question->id_classe==$classe->ID_classe)
												      				@if (!$question->cliccabile)
												      						<tr>
												      							<td colspan=2 ><b>{{$question->domanda}}</b></td>

												      						</tr>											      						
												      				@else
												      					<?php
												      						$dom = $question->ID_domanda_esercente;
												      					?>
												      					<tbody>
								        									<tr>
								              									<td>
      																				<input type="checkbox" name={{$dom}} id={{$dom}}><label for={{$dom}}></label>
      																			</td>
								              									<td>
								              										{{$question->domanda}}
								              									</td>
								              									@if ($question->domanda!=$question->descrizione)
								              									<?php
								              										$descrizione = $question->descrizione;
							              										?>
							              										<td>
								              										<!-- Modal Trigger -->	
								              										<a class="waves-effect waves-light modal-trigger" data-target={{$dom+100}}><i class="material-icons">info_outline</i></a>
								              											<!-- Modal Structure -->
								              											<div id={{$dom+100}} class="modal open" style="top:0px; display:none; z-index: 1003; opacity:0 transform: scaleX(0.7);">
								              												<div class="modal-content">
								              													<h8><b><i>Descrizione</i></b></h8><hr>
								              													<p>{{$descrizione}}</p>
								              												</div>
								              												<div class="modal-footer">
								              													<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ricevuto!</a>
								              												</div>
								              											</div>
								              										</td>
								              									@endif						     
								      										</tr>
								        								</tbody>
												      				@endif	
												      			@endif
												 		@endforeach	
													</table>	
												</div>	
											</div>	      	
								      	</div>
								    </li>
								    @endif
								    @endforeach
				  				</ul>
									<!--l'invio dei dati al model avviene attraverso il 'name' degli input-->
							<div class="row">
								<div class="input-field col s6">
								<button class="btn waves-effect waves-light" type="submit" name="action">Conferma<i class="material-icons right">send</i></button></div>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection