<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIntervenantsProcedureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->integer('agent_responsable')->unsigned();
            $table->text('intervenants_externes');
            $table->text('identifiant_procedure');
            $table->text('resume_procedure')->nullable();

            $table->foreign('agent_responsable')->references('id')->on('users')->onDelete('cascade');
        });

        // Agent responsable suppléant
        Schema::create('ars_service', function (Blueprint $table) {
          $table->integer('user_id')->unsigned();
          $table->integer('service_id')->unsigned();

          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });

        // Autres agents impliqués
        Schema::create('aai_service', function (Blueprint $table) {
          $table->integer('user_id')->unsigned();
          $table->integer('service_id')->unsigned();

          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('ars_service');
        Schema::dropIfExists('aai_service');

        Schema::table('services', function (Blueprint $table) {
          //$table->dropColumn('agent_responsable');
          $table->dropColumn('intervenants_externes');
          $table->dropColumn('identifiant_procedure');
          $table->dropColumn('resume_procedure');
        });
    }
}
