<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestructureUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->integer('entry_id')->unsigned()->nullable();
            $table->tinyInteger('crew')->unsigned()->default(0);
            $table->string('photo')->nullable();
            $table->string('section')->nullable();

            $table->string('password')->nullable()->change();

            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
        });

        Schema::table('entries', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('agency')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();

            $table->dropForeign('entries_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign('documents_entry_id_foreign');

            $table->renameColumn('entry_id', 'user_id');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::drop('profiles');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();

            $table->dropForeign('users_entry_id_foreign');
            $table->dropColumn([
                'name', 'entry_id', 'crew', 'photo', 'section',
            ]);
        });
        
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'agency', 'address', 'phone', 'city',
            ]);

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign('documents_user_id_foreign');

            $table->renameColumn('user_id', 'entry_id');
            
            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('school')->nullable();
            $table->string('city')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
}
