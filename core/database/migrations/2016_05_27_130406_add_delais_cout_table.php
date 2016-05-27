<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDelaisCoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('cout_client')->nullable();
            $table->string('delai_charge');
            $table->string('delai_oeuvre');
            $table->string('delai_tiers');
            $table->string('marge_securite');
            $table->text('remarque_delai')->nullable();
            $table->text('rh_interne');
            $table->string('cout_externalisation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('cout_client');
            $table->dropColumn('delai_charge');
            $table->dropColumn('delai_oeuvre');
            $table->dropColumn('delai_tiers');
            $table->dropColumn('marge_securite');
            $table->dropColumn('remarque_delai');
            $table->dropColumn('rh_interne');
            $table->dropColumn('cout_externalisation');
        });
    }
}
