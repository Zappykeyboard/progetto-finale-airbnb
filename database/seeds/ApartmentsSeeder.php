<?php

use Illuminate\Database\Seeder;
use App\Apartment;
use App\User;

class ApartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Apartment::class, 50)
          -> make()
          -> each(function($apt){

             $user = User::inRandomOrder() -> first();

             $apt -> user() -> associate($user);
             $apt -> save();

          });
    }
}
