<?php

use Illuminate\Database\Seeder;
use App\Apartment;

class ApartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Apartment::class, 50)->create();
    }
}
