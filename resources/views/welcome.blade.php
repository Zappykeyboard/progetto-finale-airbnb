@extends('layouts.base')

@section('content')
  <ul>
    @foreach ($apts as $apt)
      <li>{{$apt->description}}
        <a href="{{route('apt.show', $apt->id)}}">Visualizza</a> <br>
        Proprietario: {{$apt->user->lastname}}</li>
    @endforeach
  </ul>


@endsection
