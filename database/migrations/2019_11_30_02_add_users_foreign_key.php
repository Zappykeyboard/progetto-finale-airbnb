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
      //Tabella APARTMENTS
      Schema::table('apartments', function (Blueprint $table) {
        $table -> bigInteger('user_id') -> unsigned() -> index();
        $table -> foreign('user_id', 'user_apartments')
               -> references('id')
               -> on('users');

      Schema::table('apartment_feature', function (Blueprint $table) {
        $table -> bigInteger('apartment_id') -> unsigned() -> index();
        $table -> foreign('apartment_id', 'apartment_feature')
               -> references('id')
               -> on('apartments');


        $table -> bigInteger('feature_id') -> unsigned() -> index();
        $table -> foreign('feature_id', 'features_apartments')
               -> references('id')
               -> on('features');
             });


        $table -> bigInteger('tier_id') -> unsigned() ->default('1') -> index();
        $table -> foreign('tier_id', 'apartment_tiers')
               -> references('id')
               -> on('tiers');
       });

       // Tabella MESSAGES
       Schema::table('messages', function (Blueprint $table) {
         $table -> bigInteger('apartment_id') -> unsigned() -> index();
         $table -> foreign('apartment_id', 'apartment_messages')
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
      // Drop Chiavi esterne apartment_feature
        Schema::table('apartment_feature', function (Blueprint $table) {

          $table -> dropForeign('apartment_feature');
          $table -> dropColumn('apartment_id');
          $table -> dropForeign('features_apartments');
          $table -> dropColumn('feature_id');
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
          $table -> dropForeign('apartment_messages');
          $table -> dropColumn('apartment_id');

        });

    }
}
