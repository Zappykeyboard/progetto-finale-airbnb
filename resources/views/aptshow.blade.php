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
      <img class="otherjpg col-md-12" src="/img/uploads/{{$apt->img_path}}" alt="Foto dell'appartamento">
    </div>

    {{-- section 2 sotto immagine --}}
    <section class="row">
      {{-- Col Descrizione --}}
      <div class="card desc col-md-8 col-sm-12">
        <h5 class="card-header">Descrizione:</h5>
        <div class="card-body">
          <h5 class="card-title">Cosa ti racconto...</h5>
          <p class="card-text">{{$apt->description}}</p>
        </div>
      </div>

      {{-- Col Info appartamento --}}
      <div class="info col-md-4 col-sm-12">

        <ul class="list-group info col-md-12">
          <div class="card-header">
            <h3>Informazioni</h3>
          </div>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Dimensioni:
            <span class="">mq</span>
            <span class="badge badge-primary badge-pill">{{$apt->mq}}</span>
          </li>

          <li class="list-group-item d-flex justify-content-between align-items-center">
            Numero di camere:
            <span class="badge badge-primary badge-pill">{{$apt->rooms}}</span>
          </li>

          <li class="list-group-item d-flex justify-content-between align-items-center">
            Posti letto:
            <span class="badge badge-primary badge-pill">{{$apt->beds}}</span>
          </li>

          <li class="list-group-item d-flex justify-content-between align-items-center">
            Numero di bagni:
            <span class="badge badge-primary badge-pill">{{$apt->bathrooms}}</span>
          </li>

          <li class="list-group-item d-flex justify-content-between align-items-center">
            Indirizzo:
            <span class="badge badge-primary badge-pill">{{$apt->address}}</span>
          </li>

          @if(Auth::id()==$apt->user->id)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Visualizzazioni: {{$apt-> visualizations}} <br>
            <a href="{{route('apt.edit', $apt->id)}}">Modifica...</a> <br>
            <a href="{{route('apt.destroy', $apt->id)}}">!!ELIMINA!!</a> <br>
          </li>
          @endif

        </ul>

      </div>

    </section>

    {{-- Section 3 --}}
    <section class="row">
      {{-- Colonna servizi appartamento --}}
      <div class="servizi col-md-6 col-sm-12">
        <div class="card servizi col-md-6 col-sm-12">
          <h5 class="card-header">Servizi disponibili</h5>
          <div class="card-body">

              @foreach ($apt -> features as $feature)
                <p>{{ $feature -> type }}</p>
              @endforeach

          </div>
        </div>


      </div>

      {{-- Colonna contatti --}}
      <div class="contact col-md-6">

        <div id="vue_messages">
          <messages
                    :apt_id= "{{ $apt->id }}"
          ></messages>
        </div>

      </div>

    </section>

    <section class="row">


        @if (Auth::id()==$apt->user->id)
          @include('component.payment_checkout')
          @php
            $tier_active = App\Tier::where("id", $apt -> tier_id)->select('price', 'level', 'duration')->get();
            $storyPayments = $apt -> payments()->get();
          @endphp
        {{-- componenete pagamento --}}
        <div id="vue_payment" class="col-md-6 col-sm-12">
          <payments
                    :apt_id= "{{ $apt -> id}}"
                    :user_id="{{ $apt->user-> id }}"
                    :tier_id="{{ $apt-> tier_id }}"
                    :tier_active="{{ $tier_active }}"
                    :payments_story="{{ $storyPayments }}"
          ><payments>
        </div>
        @endif



    </section>



  </main>
  
  {{-- BRAINTREE PAYMENT --}}
    <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>

    <script>
      var form = document.querySelector('#payment-form');
      //Se occorre registrare i metodi di pagamento, bisogna creare customer_id (Id braintree) su tabella user
      var client_token = "sandbox_8hrkkqn6_dh357c6zpkqxdvm9"; // PER TEST, TOKEN STATICO ACCOUNT BRAINTREE
      //TODO nascondere nel back end

      braintree.dropin.create({
        authorization: client_token,
        selector: '#bt-dropin',
        paypal: {
          flow: 'vault'
        }
      }, function (createErr, instance) {
        if (createErr) {
          console.log('Create Error', createErr);
          return;
        }
        form.addEventListener('submit', function (event) {
          event.preventDefault();
          instance.requestPaymentMethod(function (err, payload) {
            if (err) {
              console.log('Request Payment Method Error', err);
              return;
            }
            // Add the nonce to the form and submit
            document.querySelector('#nonce').value = payload.nonce;

            form.submit();
          });
        });
      });
  </script>

@endsection
