<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllRequiredTablesAndModifySome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('keys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('key_user', function (Blueprint $table) {
            $table->integer('key_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('key_id')
                ->references('id')
                ->on('keys')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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

        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('content');
            $table->timestamps();
        });

        Schema::create('alert_user', function (Blueprint $table) {
            $table->integer('alert_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->dateTime('seen_at')->nullable();

            $table->foreign('alert_id')
                ->references('id')
                ->on('alerts')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('short_description')->nullable();
            $table->string('icon');
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned();
            $table->dateTime('when')->nullable();
            $table->timestamps();

            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
                ->onDelete('cascade');
        });

        Schema::create('entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('stage')->unsigned()->default(1);
            $table->tinyInteger('status')->unsigned()->default(1);

            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id')->unsigned();
            $table->string('picture');
            $table->tinyInteger('type')->unsigned();
            $table->timestamps();

            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
        });

        Schema::create('attempts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id')->unsigned();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();

            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->string('picture')->nullable();
            $table->timestamps();
        });

        Schema::create('choices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->text('content')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attempt_id')->unsigned();
            $table->integer('choice_id')->unsigned();
            $table->timestamps();

            $table->foreign('attempt_id')
                ->references('id')
                ->on('attempts')
                ->onDelete('cascade');

            $table->foreign('choice_id')
                ->references('id')
                ->on('choices')
                ->onDelete('cascade');
        });

        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id')->unsigned();
            $table->string('picture');
            $table->text('description');
            $table->timestamps();

            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('picture');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('picture')->nullable();
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id')->unsigned();
            $table->string('content');
            $table->tinyInteger('rating')->unsigned();
            $table->timestamps();

            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
        });

        Schema::create('edits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('editable_id')->unsigned();
            $table->string('editable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edits');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('news');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('submissions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('choices');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('attempts');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('entries');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('alert_user');
        Schema::dropIfExists('alerts');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('key_user');
        Schema::dropIfExists('keys');
        Schema::dropIfExists('roles');
    }
}
