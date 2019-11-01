<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('body');
            $table->string('sender_email');
            $table->timestamps();
        });

        // AGGIUNGE CHIAVE ESTERNA
        Schema::table('messages', function (Blueprint $table) {
          $table -> bigInteger('apartment_id') -> unsigned() -> index();
          $table -> foreign('apartment_id', 'apartament_messages')
                 -> references('id')
                 -> on('apartments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
