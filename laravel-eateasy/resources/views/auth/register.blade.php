@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col s12">
			<h3 class="header">Registrati</h3>
				<div class="row">
				@if (!empty($success))
					<div class="card blue-grey darken-1">
						<div class="card-content white-text">
							<span class="card-title">INFO</span>
							<p>{{ $success }}</p>
							</div>
					</div>
				@endif
			</div>
			<form class="col s12" role="form" method="POST" action="{{ url('/register') }}">
				{!! csrf_field() !!}
				<!-- EMAIL ADDRESS -->
				<div class="row">
					<div class="input-field col s12">
						<input id="email" name="email" type="email" class="validate" value="{{ old('email') }}">
						<label for="email" data-error="wrong" data-success="right">E-mail</label>
						<!-- comunicazione degli errori -->
						@if ($errors->has('email'))
							<div class="card blue-grey darken-1">
								<div class="card-content white-text">
									<span class="card-title">Error</span>
									<p>{{ $errors->first('email') }}</p>
								</div>
							</div>
						@endif
					</div>
				</div>
				<!-- PASSWORD -->
				<div class="row">
					<div class="input-field col s12">
						<input id="password" name="password" type="password" class="validate">
						<label for="password">Password</label>
						<!-- comunicazione degli errori -->
						@if ($errors->has('password'))
							<div class="card blue-grey darken-1">
								<div class="card-content white-text">
									<span class="card-title">Error</span>
									<p>{{ $errors->first('password') }}</p>
								</div>
							</div>
						@endif
					</div>
				</div>
				<!-- PASSWORD CONFIRMATION -->
				<div class="row">
					<div class="input-field col s12">
						<input id="password_confirmation" name="password_confirmation" type="password" class="validate">
						<label for="password_confirmation">Conferma Password</label>
						<!-- comunicazione degli errori -->
						@if ($errors->has('password_confirmation'))
							<div class="card blue-grey darken-1">
								<div class="card-content white-text">
									<span class="card-title">Error</span>
									<p>{{ $errors->first('password_confirmation') }}</p>
								</div>
							</div>
						@endif
					</div>
				</div>
				<!-- CHECKBOX ESERCENTE -->
				<div class="row">
					<div class="input-field col s12">
						<input id="check_esercente" name="check_esercente" type="checkbox" class="filled-in" id="filled-in-box" />
						  <label for="check_esercente">Sono un esercente</label>
					</div>       
				</div>
				<!-- SUBMIT -->
				<div class="row">
					<div class="input-field col s12">
						<button class="btn waves-effect waves-light" type="submit" name="action">Registrati<i class="material-icons right">send</i></button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>
@endsection
