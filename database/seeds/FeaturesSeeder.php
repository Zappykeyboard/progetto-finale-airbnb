<?php

use Illuminate\Database\Seeder;
use App\Feature;
use App\Apartment;


class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Feature::class, 15)->create();
    }
}
