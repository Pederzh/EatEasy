@extends('layouts.app')

@section('content')

@foreach($questions as $q)
 
    @foreach($q->utenteSclasse as $s)
        @foreach($s->sottoclasse as $sa)
            {{$sa}}
        @endforeach
    @endforeach
@endforeach

@endsection