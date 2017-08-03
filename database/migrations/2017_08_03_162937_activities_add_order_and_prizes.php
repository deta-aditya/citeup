<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesAddOrderAndPrizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->tinyInteger('order')->default(-1);
            $table->integer('prize_first')->unsigned()->nullable();
            $table->integer('prize_second')->unisgned()->nullable();
            $table->integer('prize_third')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('prize_third');
            $table->dropColumn('prize_second');
            $table->dropColumn('prize_first');
            $table->dropColumn('order');
        });
    }
}
