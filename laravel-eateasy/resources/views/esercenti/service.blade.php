@extends('layouts.app')

@section('content')
@foreach($questions as $q)
	{{$q}}<br>

	<!--@foreach($q->esercenteSclasse as $idsottoclasse)
		{{$idsottoclasse}}<br>
		{{$idsottoclasse->sottoclasse}}
		{{$idsottoclasse->sottoclasse->classe}}
	@endforeach-->
@endforeach

@endsection