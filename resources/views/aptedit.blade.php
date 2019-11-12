@extends('layouts.base')

@section('content_header')

  @include('component.header')

@endsection

@section('content')
  @include('component.addressBar')
  <div id="app">
    <addapartment
            route = "{{route('apt.update', $apt->id)}}"
            address = "{{$apt->address}}"
            description = "{{$apt->description}}"
            rooms = "{{$apt->rooms}}"
            beds = "{{$apt->beds}}"
            mq = "{{$apt->mq}}"
            bathrooms = "{{$apt->bathrooms}}"
    ></addapartment>
  </div>


@endsection
