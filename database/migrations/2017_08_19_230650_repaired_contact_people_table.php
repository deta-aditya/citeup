<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RepairedContactPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_people', function (Blueprint $table) {
            $table->dropColumn(['email', 'line']);
            $table->string('phone', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_people', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change();
            $table->string('email');
            $table->string('line');
        });
    }
}
