@extends('layouts.base')

@section('content_header')

  @include('component.header')

@endsection

@section('content')

  <main>

    <div class="photos col-md-12">
      <img class="otherjpg col-md-12" src="/img/uploads/{{$apt->img_path}}" alt="Foto dell'appartamento">
    </div>


    <section class="row">

      <div class="desc col-md-8">
        <h2>Descrizione:</h2>
        <h4>{{$apt->description}}</h4>
      </div>
      <div class="info col-md-4">
        <h2>Informazioni:</h2>
        <p>Dimensioni: {{$apt->mq}}mq</p>
        <p>Numero di camere: {{$apt->rooms}}</p>
        <p>Posti letto: {{$apt->beds}}</p>
        <p>Numero di bagni: {{$apt->bathrooms}}</p>
        <p>Indirizzo: {{$apt->address}}</p>
        @if(Auth::id()==$apt->user->id)
          Visualizzazioni: {{$apt-> visualizations}} <br>
          <a href="{{route('apt.edit', $apt->id)}}">Modifica...</a> <br>
          <a href="{{route('apt.destroy', $apt->id)}}">!!ELIMINA!!</a> <br>
        @endif
      </div>

    </section>

    <section class="row">

      <div class="servizi col-md-6">
        <h1>Servizi disponibili</h1>
        <ul>
          @foreach ($apt -> features as $feature)
            <li>{{ $feature -> type }}</li>
          @endforeach
        </ul>
      </div>

      <div class="contact col-md-6">

        <form class="" action="index.html" method="post">
          <h1>Contatta il proprietario</h1>
            <div class="form">
              <h3>Inserisci la Tua email</h3>
              <input type="email" name="" value="">
              <h3>Scrivi il messaggio</h3>
              <textarea id="textToPossesor" name="name" rows="5" cols="20" minlength="10" maxlength="500"></textarea>
              <input id="butt" class="button" type="button" name="" value="Manda">
            </div>

        </form>
      </div>

    </section>


  </main>
@endsection
