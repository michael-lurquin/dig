<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('categories', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->unique();
          $table->integer('weight');
      });

      Schema::create('category_service', function (Blueprint $table) {
          $table->integer('category_id')->unsigned();
          $table->integer('service_id')->unsigned();

          $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
          $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_service');
        Schema::dropIfExists('categories');
    }
}
