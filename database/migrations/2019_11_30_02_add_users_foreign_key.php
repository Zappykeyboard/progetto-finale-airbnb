<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


      //relazione many-to-many apartments-features
      Schema::table('apartments_features', function (Blueprint $table) {
        $table -> bigInteger('apartment_id') -> unsigned() -> index();
        $table -> foreign('apartment_id', 'apartments_features')
               -> references('id')
               -> on('apartments');


        $table -> bigInteger('features_id') -> unsigned() -> index();
        $table -> foreign('features_id', 'features_apartments')
               -> references('id')
               -> on('features');
             });

       //Tabella APARTMENTS
       Schema::table('apartments', function (Blueprint $table) {
         $table -> bigInteger('user_id') -> unsigned() -> index();
         $table -> foreign('user_id', 'user_apartments')
                -> references('id')
                -> on('users');

        $table -> bigInteger('tier_id') -> unsigned() ->default('1') -> index();
        $table -> foreign('tier_id', 'apartment_tiers')
               -> references('id')
               -> on('tiers');
       });

       // Tabella MESSAGES
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
      // Drop Chiavi esterne APARTMENTS_FEATURES
        Schema::table('apartments_features', function (Blueprint $table) {

          $table -> dropForeign('apartments_features');
          $table -> dropColumn('apartment_id');
          $table -> dropForeign('features_apartments');
          $table -> dropColumn('features_id');
      });

        // Drop Chiavi esterne APARTMENTS
        Schema::table('apartments', function (Blueprint $table) {

          $table -> dropForeign('user_apartments');
          $table -> dropColumn('user_id');

          $table -> dropForeign('apartment_tiers');
          $table -> dropColumn('tier_id');

      });

        // Drop Chiavi esterne MESSAGES
        Schema::table('messages', function (Blueprint $table) {
          $table -> dropForeign('user_apartments');
          $table -> dropColumn('user_id');

        });

    }
}
