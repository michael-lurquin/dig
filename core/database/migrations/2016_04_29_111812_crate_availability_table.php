<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateAvailabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('availability', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->unique();
          $table->integer('weight');
      });

      Schema::table('services', function (Blueprint $table) {
          $table->integer('availability_id')->after('identifier')->default(1)->index();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availability');
    }
}
