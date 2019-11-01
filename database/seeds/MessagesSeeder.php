<?php

use Illuminate\Database\Seeder;
use App\Message;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Message::class, 100)->create();
    }
}
