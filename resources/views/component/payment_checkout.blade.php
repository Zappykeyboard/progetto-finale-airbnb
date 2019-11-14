<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.4.2/handlebars.js"></script>
<script type="text/x-template" id="template_payments">


  <div class="col-sm-12">

  <!-- Info Piano Sottoscrizione -->
  <form id="paymeffnt-form" action="{{route('payment.send', $apt->id)}}" method="post">
    @csrf
    @method('POST')

    <div class="card text-center">
      <div class="card-header">
        Piano Attivo
      </div>
      <div class="card-body">
        <h5 class="card-title" v-if="!seenSubsBtn">Sponsorizzazioni del tuo appartamento</h5>
        <h5 class="card-title" v-if="seenSubsBtn">Nessuna Sponsorizzazione attiva</h5>

        <!-- Sponsorizzazioni attive -->
        <div class="table-responsive-lg" v-if="!seenSubsBtn">
          <table class="table table-hover">
            <thead class="thead-light">
              <tr v-for="tier in tierActive">
                <th scope="col"  v-for="(value, name) in tier">@{{ name }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="tier in tierActive">
                <th scope="row" v-for="(value, name) in tier">@{{ value }}</th>
              </tr>
            </tbody>
          </table>
        </div>


        <!-- Tabella delle sponsorizzazioni -->
        <div class="table-responsive-lg" v-if="show_form" v-for="one in resultsTiers">
          <table class="table table-hover">
            <thead class="thead-light">
              <tr>
                <th scope="col" v-for="(value, name) in one">@{{ name }} </th>
                <td>
                  <input class="checkbox_tier" type="checkbox" name="tier_id" :checked="active" :value="one.id" @click="check($event)"/>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" v-for="(value, name) in one">@{{ value }}</th>
              </tr>
            </tbody>
          </table>
        </div>

        <p class="card-text" v-if="!seenSubsBtn">@{{ results.msg_subs }}</p>

        <a class="btn btn-primary"  @click="setShowForm()" v-if="seenSubsBtn">Sottoscrivi un piano!</a>
        <a class="btn btn-primary"  @click="getFormPayment()" v-if="activePayBtn">Procedi con il pagamento!</a>
      </div>
      <div class="card-footer text-muted">
        Last Payment: @{{ results.diff }}
      </div>
    </div>

    <!-- BRAINTREE Paiment -->

  </form>

  <!-- Braintree -->
  {{-- layout pagamento --}}
  <form id="payment-form" action="{{route('payment.send', $apt->id)}}" method="post">
    @csrf
    @method('POST')

    <section>
      <div class="bt-drop-in-wrapper">
          <div id="bt-dropin"></div>
      </div>

      <input id="nonce" name="payment_method_nonce" type="hidden" />
      <button class="button" type="submit"><span>Test Transaction</span></button>
    </section>


  </form>

</div>

</script>



<script type="text/javascript">

var token = $('meta[name="csrf-token"]').attr('content');

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

  Vue.component('payments', {
    template: '#template_payments',

    data: function(){

      return {
        showForm: false,
        this_address: this.address,
        token_payment: "",
        tiers: null,
        showInfo: true,
        showPayForm: false,
        showPayBrayntree: false,
        tierActive: this.tier_active,
        seenSubsBtn : true,
        msgSubscription : "",
        lastPayment: "",
        results: [],
        active: false,
        resultsTiers: [],
        show_form: false,
        activePayBtn: false,
        form: {
              apt_id: this.apt_id,
              user_id: this.user_id,
              tier_id: null
            },

      }

    },

    props: {

      // apt2_id: Number,
      // msg: String,
      address: String,
      apt_id: Number,
      user_id: Number,
      tier_active: Array,
      payments_story: Array,
      tier_id: Number

    },

    mounted() {
      axios.get('/index/' + this.apt_id)
      .then( (res) => {

        this.msgSubscription = res.data.msgSubscription;
        this.results = res.data;


        console.log("mounted response" , res.data, this.msgSubscription, res.data.tier_id_apt);
      })
      .catch( error => { console.log(error); });
      console.log("mounted" , this.results);

    },

    created() {

      // this.returnMsgSubscription;
      console.log("created component" + this.msgSubscription);
      if (this.tier_id > 1) {
        this.seenSubsBtn = false;
      }
      console.log(this.seenSubsBtn);

    },
  //

    computed: {

      // Ritorno msg stringa da Array results, da chiamata axios
      returnMsgSubscription: function () {

        console.log("ciao", this.results.msg_subs);
        return this.results.msg_subs;
      },

    },

    methods: {

      // Funzione per check unico checkbox
      check(e){
        if (e.target.checked) {

          // Attivo il bottone pagamento se ho cliccato
          //su almenno una check box
          this.activePayBtn = true;
          // Gruppo delle check box
          var x = document.getElementsByClassName("checkbox_tier");
          var i;
          // Disattivo il Check su tutti gli elementi
          for (i = 0; i < x.length; i++) {

            x[i].style.backgroundColor = "red";
            x[i].checked = false;

            console.log("Set all false", x[i]);
          }

          // Setto attributo check su elemento cliccato
          e.target.checked = true;

          // Assegno al Form il valore id tier cliccato
          this.form.tier_id = e.target.value;

          console.log("event.target", e.target, e.target.value, this.form.tier_id);

          // se non ho nessuna box attiva
        }else if(!e.target.checked){
           //Disattivo il bottone modulo pagamento
            this.activePayBtn = false;
        }

      },

      setShowForm(){

        this.show_form = !this.show_form;
        console.log(this.show_form);

        this.getTableTiers();
        console.log("results tiers from click" , this.resultsTiers);
      },


      getTableTiers(){

        console.log("ciao");

        axios.get('/tiers/' + this.apt_id)
        .then( (res) => {

          this.resultsTiers = res.data.tiers;
          console.log("response get tiers", res, this.resultsTiers);
        })
        .catch( error => { console.log(error); });

      },


      getFormPayment(){

        this.showPayForm = !this.showPayForm;
        // Mostro il form per inserimento dati carta di credito
        this.showPayBrayntree = true;
        console.log(this.showPayBrayntree);
        // this.showPayBrayntree = true;
        var user_data = {

          _token: token,
          apartment_id: this.apt_id
        };
        console.log(user_data);
        //
        axios.get('/payment/' + this.apt_id, user_data)
          .then(function(res){

            // Salvo il token per la sessione braintree nella variabile in data
            // this.token_payment = res.data['token-braintree'];
            // Salvo i valori di ritorno della tabella tiers in un ARRAY
            // this.tiers = res.data['tiers'];

            console.log(res);
          })
          .catch(function(err){
            console.log(err);
          });

      }

    },

    watch:{

      // 'msgSubscription': function(val){
      //
      //   this.msgSubscription = val ;
      //  },

      'lastPayment': function(val){

          this.lastPayment = val;
       },

    }

  });

</script>
