@extends('layouts.base')

@section('content_header')
    @include('component.header')
@endsection

@section('content')
  <h1>Ricerca appartamenti: </h1>
  @isset($results)
    @foreach ($results as $res)
      <p>{{$res->description}}</p>
    @endforeach
  @endisset

@endsection
