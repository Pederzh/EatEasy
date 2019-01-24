@extends('layouts.app')

<!-- Main Content -->
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

                <form class="col s12" role="form" method="POST" action="{{ url('/password/email') }}">
                {!! csrf_field() !!}
                    <!-- EMAIL -->
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

                    <!-- SUBMIT -->
                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Send Password Reset Link<i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
@endsection
