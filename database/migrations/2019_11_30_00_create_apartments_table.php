<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('description')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('beds')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('mq')->nullable();
            $table->string('address');
            $table->string('geo_coords');
            $table->integer('visualizations')->nullable();
            $table->boolean('active')->nullable();
        });

          Schema::table('apartments', function (Blueprint $table) {
            $table -> bigInteger('user_id') -> unsigned() -> index();
            $table -> foreign('user_id', 'user_apartments')
                   -> references('id')
                   -> on('users');

           $table -> bigInteger('tier_id') -> unsigned() -> index();
           $table -> foreign('tier_id', 'apartment_tiers')
                  -> references('id')
                  -> on('tiers');
          });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');

        Schema::table('apartments', function (Blueprint $table) {

        $table -> dropForeign('user_apartments');
        $table -> dropColumn('user_id');

        $table -> dropForeign('apartment_tiers');
        $table -> dropColumn('tier_id');

      });
    }
}
