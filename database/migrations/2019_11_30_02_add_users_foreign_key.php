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

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      Schema::table('apartments_features', function (Blueprint $table) {
      $table -> dropForeign('apartments_features');
      $table -> dropColumn('apartment_id');
      $table -> dropForeign('features_apartments');
      $table -> dropColumn('features_id');
    });


    }
}
