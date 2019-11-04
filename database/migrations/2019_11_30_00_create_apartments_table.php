<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->text('description')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('beds')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('mq')->nullable();
            $table->string('address')->nullable();
            $table->string('geo_coords')->nullable();
            $table->integer('visualizations')->nullable()->default('0');
            $table->boolean('active')->nullable()->default('1');
        });

        DB::statement('ALTER TABLE apartments ADD FULLTEXT fulltext_index (description, address)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');

    }
}
