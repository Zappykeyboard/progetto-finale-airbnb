<?php

use Illuminate\Database\Seeder;
use App\ApartmentFeature;
use App\Apartment;
use App\Feature;

class ApartmentsFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(ApartmentFeature::class, 50)-> create()
        -> each(function($apartment){
           //Aggiungo valori per chiave estern user_id
           $apartment = Apartment::inRandomOrder() -> first();
           $feature = Feature::inRandomOrder() -> take(rand(1,15));

           $apartment -> features() -> attach($feature);

           $apartamentFeature -> save();
  });
    }
}
