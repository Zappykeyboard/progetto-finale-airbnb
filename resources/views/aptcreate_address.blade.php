@extends('layouts.base')

@section('content_header')

  @include('component.header')

@endsection

@section('content')
  @include('component.addressBar')

  <div id="app">
    <addapartment
            route="{{ route('apt.store') }}"
    ></addapartment>
  </div>
@endsection
