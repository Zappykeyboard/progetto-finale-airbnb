@extends('layouts.base')

@section('content')

  @foreach ($apts as $apt)
    <p>{{$apt->description}} Proprietario: {{$apt->user->lastname}}</p>
  @endforeach

@endsection
