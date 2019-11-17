<script type="text/x-template" id="template_map">

  <div class="">

    <div class="">
      <div class="card bg-dark text-white">
        <img v-bind:src="mapImg" class="card-img" alt="map_TOM_TOM">
        <div class="card-img-overlay">
          <h5 class="card-title">@{{ msgDefault }}</h5>
          <p class="card-text">@{{ address }}</p>
        </div>
      </div>
    </div>
    <input style="z-index: 5" type="button" name="ss" value="mappa" @click="axiosMap()">

  </div>

</script>



<script type="text/javascript">

var token = $('meta[name="csrf-token"]').attr('content');

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

  Vue.component('map-tom-tom', {
    template: '#template_map',

    data: function(){

      return {

        address: this.apt_address,
        mapImg: "/img/img_front/map_default.png",
        msgDefault: "Nessuna Mappa Disponibile",
        thisAptId: this.apt_id,

      }

    },

    props: {

      apt_address : String,
      apt_id: Number
    },

    mounted() {


    },

    created() {

      this.axiosMap()

    },


    computed: {


    },

    methods: {


      axiosMap(){

        // var thisAddress = this.address;

        console.log("axiosMap");
        axios.post(`/map/` + this.thisAptId, {address: this.apt_address})
          .then(response => {

            var objAddress = response.data.body.results[0].address;
            // Assegno il nome corretto di indirizzo
            this.address = objAddress.freeformAddress;
            // Cambio messagiio nessuna mappa con:
            this.msgDefault = "MAPPA";
            // Creo la src per immagine mappa
            this.mapImg = "/img/mapTomTom/" + response.data.filename;
            console.log('map tom tom response', response, response.data.filename);
          })
          .catch(e => {
            console.log("errors", e);
          })
          // return thisAddress
      }


    },

    watch:{



    }

  });

</script>
