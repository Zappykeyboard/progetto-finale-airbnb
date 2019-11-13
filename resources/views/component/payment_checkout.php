<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.4.2/handlebars.js"></script>
<script type="text/x-template" id="template_payments">
  <div class="col-sm-12">
  <!-- Info Piano Sottoscrizione -->


  <!--  layout pagamento  -->
  <form id="payment-form" action="#" method="post">
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
                <th scope="col"  v-for="(value, name) in tier">{{ name }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="tier in tierActive">
                <th scope="row" v-for="(value, name) in tier">{{ value }}</th>
              </tr>
            </tbody>
          </table>
        </div>


        <p class="card-text" v-if="!seenSubsBtn">{{ results.msg_subs }}</p>
        <!-- <p class="card-text"  v-if="isExpiredTime(seenSubsBtn)">dddd</p> -->

        <a class="btn btn-primary"  @click="setShowForm()" v-if="seenSubsBtn">Sottoscrivi un piano!</a>
      </div>
      <div class="card-footer text-muted">
        Last Payment: {{ results.diff }}
      </div>
    </div>


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
        tierActive: this.tier_active,
        seenSubsBtn : true,
        msgSubscription : "",
        lastPayment: "",
        results: [],
        show_form: false

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

      setShowForm(){

        this.show_form = !this.show_form;
        console.log(this.show_form);
      },

      getFormPayment(){

        alert(this.msgSubscription);
        this.getInfo();
        var user_data = {

          _token: token,
          apartment_id: this.apt_id
        };
        console.log(user_data);
        //
        axios.get('/payment/' + this.apt_id, user_data)
          .then(function(res){

            // Salvo il token per la sessione braintree nella variabile in data
            this.token_payment = res.data['token-braintree'];
            // Salvo i valori di ritorno della tabella tiers in un ARRAY
            this.tiers = res.data['tiers'];




            console.log(res.data, this.token_payment, this.tiers,);
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
