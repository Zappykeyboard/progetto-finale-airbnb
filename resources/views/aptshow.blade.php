@extends('layouts.base')

@section('content_header')

  @include('component.header')

@endsection

@section('content')

  @include('component.messages')


  @php
    use App\Tier;
    use App\Payment;

    $tiers = DB::table('tiers')->where('level', '>', 0)->orderBy('level', 'asc')
                ->get();

  @endphp


  <main>

    <div class="photos col-md-12">
      <img class="otherjpg col-md-12"
      @isset($apt->img_path)
        src="/img/uploads/{{$apt->img_path}}"
      @endisset

      alt="Foto dell'appartamento">

    </div>

    <div class="container">
    {{-- section 2 sotto immagine --}}
    <section class="row">
      {{-- Col Descrizione --}}
      <div class="col-lg-6 col-sm-12">
        <div class="card-header">
          <h3 class="">Descrizione:</h3>
        </div>
        <div class="card-body">
          <h5 class="card-title">Cosa ti racconto...</h5>
          <p class="card-text">{{$apt->description}}</p>
        </div>
      </div>

      {{-- Col Info appartamento --}}

        <ul class="info col-lg-6 col-sm-12">
          <div class="card-header">
            <h3>Informazioni</h3>
          </div>

          <div class="card-body">

            <li class="my_list_group_item d-flex justify-content-between align-items-center">
              Dimensioni:
              <span class="">mq</span>
              <span class="badge badge-primary badge-pill">{{$apt->mq}}</span>
            </li>

            <li class="my_list_group_item d-flex justify-content-between align-items-center">
              Numero di camere:
              <span class="badge badge-primary badge-pill">{{$apt->rooms}}</span>
            </li>

            <li class="my_list_group_item d-flex justify-content-between align-items-center">
              Posti letto:
              <span class="badge badge-primary badge-pill">{{$apt->beds}}</span>
            </li>

            <li class="my_list_group_item d-flex justify-content-between align-items-center">
              Numero di bagni:
              <span class="badge badge-primary badge-pill">{{$apt->bathrooms}}</span>
            </li>

            <li class="my_list_group_item d-flex justify-content-between align-items-center">
              Indirizzo:
              <span class="badge badge-primary badge-pill">{{$apt->address}}</span>
            </li>

            @if(Auth::id()==$apt->user->id)
            <li class="my_list_group_item d-flex justify-content-between align-items-center">
              Visualizzazioni: {{$apt-> visualizations}} <br>
              <a href="{{route('apt.edit', $apt->id)}}">Modifica...</a> <br>
              <a href="{{route('apt.destroy', $apt->id)}}">!!ELIMINA!!</a> <br>
            </li>
            @endif
          </div>
        </ul>



    </section>

    {{-- Section 3 --}}
    <section class="row">

      {{-- Colonna servizi appartamento --}}
        <div class="servizi col-lg-6 col-md-12 col-sm-12">
          <div class="card-header">
            <h3 class="">Servizi disponibili</h3>
          </div>
          <div class="card-body">

              @foreach ($apt -> features as $feature)
                <p>{{ $feature -> type }}</p>
              @endforeach

          </div>
        </div>

      {{-- Colonna contatti --}}
      <div id="vue_messages" class="contact col-lg-6 col-md-12 col-sm-12">


          <messages
                    :apt_id= "{{ $apt->id }}"
          ></messages>


      </div>

    </section>

        @if (Auth::id()==$apt->user_id)
          @include('component.payment_checkout')
          @php
            $tier_active = App\Tier::where("id", $apt -> tier_id)->select('price', 'level', 'duration')->get();
            $storyPayments = $apt -> payments()->get();
          @endphp
        {{-- componenete pagamento --}}
        <section id="vue_payment" class="row">

          <payments
                    :apt_id= "{{ $apt -> id}}"
                    :user_id="{{ $apt->user-> id }}"
                    :tier_id="{{ $apt-> tier_id }}"
                    :tier_active="{{ $tier_active }}"
                    :payments_story="{{ $storyPayments }}"
          ><payments>


            {{-- Mappa --}}
            <div class="col-lg-6 col-md-12">
              <div class="card bg-dark text-white">
                <img src="..." class="card-img" alt="...">
                <div class="card-img-overlay">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <p class="card-text">Last updated 3 mins ago</p>
                </div>
              </div>
            </div>

        </section>
        @endif

      </div>
  </main>




@endsection
