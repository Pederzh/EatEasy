@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col s12">
			<h3 class="header">Login</h3>
			<form class="col s12" role="form" method="POST" action="{{ url('/login') }}">
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
				<!-- REMEMBER ME -->
				<div class="row">
					<div class="input-field col s12">
						<p>
							<input type="checkbox" id="remember" name="remember"/>
							<label for="remember">Ricordami</label>
						</p>
					</div>
				</div>
				<!-- SUBMIT -->
				<div class="row">
					<div class="input-field col s12">
						<button class="btn waves-effect waves-light" type="submit" name="action">Login<i class="material-icons right">send</i></button>
						<a class="waves-effect waves-light right" href="{{ url('/password/reset') }}">Password dimenticata?</a> 
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
