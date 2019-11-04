@extends('layouts.base')
@php
  use App\Apartment;
  $apts = Apartment::where('user_id', Auth::id())->get();

@endphp
@section('content_header')
  @include('component.header')
@endsection


@section('content')
  <a href="{{route('apt.create')}}">Registra un nuovo appartamento...</a>
<div class="container">
  @if (!empty($apts))
    @foreach ($apts as $apt)
      <div class="col-md-4 col-xs-12">
        <h4>{{$apt->description}}</h4>
        <div class="">
          <p>Dimensioni: {{$apt->mq}}mq</p>
          <p>Numero di camere: {{$apt->rooms}}</p>
          <p>Posti letto: {{$apt->beds}}</p>
          <p>Numero di bagni: {{$apt->bathromms}}</p>
          <p>Indirizzo: {{$apt->address}}</p>
          <p>Visualizzazioni: {{rand(100, 500)}}</p>
          <a href="{{route('apt.show', $apt->id)}}">Visualizza</a> <br>
        </div>
      </div>
    @endforeach

  @else
    <h4>Non hai registrato alcun appartamento!</h4>
  @endif


</div>
@endsection
