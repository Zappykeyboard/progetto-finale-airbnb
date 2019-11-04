<?php

use Illuminate\Database\Seeder;
use App\Message;
use App\Apartment;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crea e popola i campi e le chiavi esterne associate
        factory(Message::class, 100)

          ->make()
          ->each(function($message){

            $apartment = Apartment::inRandomOrder() -> first();

            $message -> apartment() -> associate($apartment);

            $message -> save();


          });
    }
    
}
