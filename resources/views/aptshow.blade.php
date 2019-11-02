@extends('layouts.base')

@section('content')
  <h4>{{$apt->description}}</h4>
  <div class="">
    <p>Dimensioni: {{$apt->mq}}mq</p>
    <p>Numero di camere: {{$apt->rooms}}</p>
    <p>Posti letto: {{$apt->beds}}</p>
    <p>Numero di bagni: {{$apt->bathromms}}</p>
    <p>Indirizzo: {{$apt->address}}</p>
    @auth
      Visualizzazioni: {{$apt-> visualizations}}
    @endauth
  </div>
@endsection