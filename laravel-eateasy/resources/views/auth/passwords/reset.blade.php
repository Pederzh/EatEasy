@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <h3 class="header">Reset Password</h3>
            @if (session('status'))
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Info</span>
                        <p>{{ session('status') }}</p>
                    </div>
                </div>
            @endif
            <form class="col s12" role="form" method="POST" action="{{ url('/password/reset') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}">
                        <label for="email" data-error="wrong" data-success="right">E-mail Address</label>
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
                        <input id="password" name="password" type="password" class="validate" value="">
                        <label for="password" data-error="wrong" data-success="right">Password</label>
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
                        <input id="password_confirmation" name="password_confirmation" type="password" class="validate" value="">
                        <label for="password_confirmation" data-error="wrong" data-success="right">Confirm Password</label>
                        <!-- comunicazione degli errori -->
                        @if ($errors->has('password-confirmation'))
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                    <span class="card-title">Error</span>
                                    <p>{{ $errors->first('password-confirmation') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="action">Reset Password<i class="material-icons right">send</i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

