<?php

use Illuminate\Database\Seeder;
use App\Tier;

class TiersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tier::class, 3)->create();
    }
}
