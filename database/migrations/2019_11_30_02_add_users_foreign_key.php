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

      //relazione one to many users-apartments
      Schema::table('apartments', function (Blueprint $table){
        $table -> bigInteger('user_id') -> unsigned() -> index();
        $table -> foreign('user_id', 'user_apartments')
               -> references('id')
               -> on('users');
      });

      //relazione many-to-many apartments-features
      Schema::table('apartments_features', function (Blueprint $table) {
        $table -> bigInteger('apartament_id') -> unsigned() -> index();
        $table -> foreign('apartament_id', 'apartaments_features')
               -> references('id')
               -> on('apartments');


        $table -> bigInteger('features_id') -> unsigned() -> index();
        $table -> foreign('features_id', 'features_apartaments')
               -> references('id')
               -> on('features');
             });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('apartments', function (Blueprint $table){
        $table -> dropForeign('user_apartment');
        $table -> dropColumn('user_id');
      });

      Schema::table('apartments_features', function (Blueprint $table) {
        $table -> dropForeign('apartaments_features');
        $table -> dropColumn('apartament_id');
        $table -> dropForeign('features_apartaments');
        $table -> dropColumn('features_id');
    });


    }
}
