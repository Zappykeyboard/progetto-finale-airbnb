@extends('layouts.base')

@section('content')
  <div class="container">
    <form class="" action="{{route('apt.store')}}" method="post">
      @csrf
      @method('POST')
      <div class="">
        <label for="description">Descrizione: </label>
        <textarea name="description" rows="8" cols="80"></textarea>
      </div>
      <div class="">
        <label for="address">Indirizzo: </label>
        <input type="text" name="address" value="">
      </div>
      <div class="">
        <label for="geo_coords">Coordinate geoloc</label>
        <input type="text" name="geo_coords" value="">
      </div>
      <div class="">
        <input type="submit" value="Invia">
      </div>
    </form>
  </div>
@endsection
