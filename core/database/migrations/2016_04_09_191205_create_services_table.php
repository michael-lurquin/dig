<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('identifier')->unique();
            $table->integer('user_id')->index();
            $table->string('description_categorie')->nullable();
            $table->string('contexte')->nullable();
            $table->string('description')->nullable();
            $table->string('exclus_perimetre')->nullable();
            $table->string('prerequis')->nullable();
            $table->string('contact_general')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
