<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
use App\Feature;
use App\Payment;
use App\Tier;

class IndexController extends Controller
{
    public function index(){

      $all_apts = Apartment::all()->each(function($apartment){

        // CONTROLLO E AGGIORNO IL CAMPO dI TIER_ID PER LA VISIBILITÀ DELL'APPARTAMENTO
          $payments = Payment::where('apartment_id', $apartment -> id)->each(function($payment) use($apartment){

              $tier_active = Tier::findOrFail($apartment -> tier_id);
              $level_duration = $tier_active -> duration;

              if($level_duration != null & $level_duration > 0){

                $date_creation_payment = $payment -> created_at;

                // Metodo che aggiunge ad una data un numero X di ore
                $time = date("Y-m-d H:i:s", strtotime('+' . $level_duration . 'hours'));
                $now = date("Y-m-d H:m:s");

                if ($now > $time) {

                  // TODO SE la data di oggi è maggiore di quella di scadenza pagamento, bisogna aggiornare
                  // il campo di tier_id nella tabella apartmnets, con uno 0
                  // dd($apartment -> tier_id, $tier_active, $payment -> created_at , $level_duration, $new_time, $now);
                }
              }

          });
      });

      $apts = Apartment::where('tier_id', '>', '0')
                ->orderBy('tier_id', 'desc')
                -> take(10)
                -> get();
      $features = Feature::all();
      return view('welcome', compact('apts', 'features'));
    }
}
