<script type="text/x-template" id="template_messages">

  @php
    use App\Message;
    $messages = Message::all()->take(5);
  @endphp

  <div class="box">

    <!-- <form class="" action="{{ route('msg.store', $apt-> id ) }}" method="post">
      @csrf
      @method('POST')

      <h1>Contatta il proprietario</h1>
        <div class="form">
          <label for="sender_email"><h3>Inserisci la Tua email</h3></label>
          <input type="email" name="sender_email" value="">
          <label for="body"><h3>Scrivi il messaggio</h3></label>
          <textarea #id="textToPossesor" name="body" rows="5" cols="20" minlength="10" maxlength="500"></textarea>
          <input id="sub-message" class="button" type="submit" name="" value="Manda">
        </div>

    </form> -->
    <div class="messages">
      @foreach ($messages as $message)
        <div class="card text-white bg-dark mb-3 col-lg-12">
          <div class="card-header">Messaggio da: {{$message -> sender_email}}</div>
          <div class="card-body">
            <h5 class="card-title">Appartamento: {{$apt->address}}</h5>
            <p class="card-text">{{$message -> body}}</p>
          </div>
        </div>
      @endforeach
    </div>

    @if (Auth::user() -> id == $apt -> user -> id)
      @else
      @endif



  </div>

</script>


<script type="text/javascript">

  Vue.component('messages', {

    template: '#template_messages',

    data: function(){

      return {

        user_id: this.id,
        address_added: false
      }
    },

    props: {

      id: Number
    },

    computed: {



    },

    methods: {


    }

  });

</script>
