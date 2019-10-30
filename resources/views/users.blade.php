@extends('welcome')

@section('content')

  @foreach ($users as $user)

    <div class="user">
      {{$user->lastname}}, {{$user->firstname}}
    </div>
  @endforeach
@endsection
