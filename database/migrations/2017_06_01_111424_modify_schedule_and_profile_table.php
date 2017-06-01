<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyScheduleAndProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->renameColumn('when', 'held_at');
            $table->string('description');
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->string('section')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('section');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->renameColumn('held_at', 'when');
        });
    }
}
