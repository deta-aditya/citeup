<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RepairedUsersAndEntriesTableAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('birthplace');
            $table->date('birthdate');
            $table->text('address');
            $table->string('phone');
        });

        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birthplace', 'birthdate', 'address', 'phone']);
        });
        
        Schema::table('entries', function (Blueprint $table) {
            $table->text('address');
            $table->string('phone');
        });
    }
}
