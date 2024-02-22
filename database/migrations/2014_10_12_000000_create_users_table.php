<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('pronoun')->nullable();
            $table->string('used_agreements')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('gender_show')->default(0);
            $table->string('title')->nullable();
            $table->boolean('title_show')->default(0);
            $table->string('environment')->nullable();
            $table->boolean('environment_show')->default(0);
            $table->date('birthdate')->nullable();
            $table->boolean('birthdate_show')->default(0);
            $table->integer('years_xp')->nullable();
            $table->boolean('years_xp_show')->default(0);
            $table->string('work_city')->nullable();
            $table->boolean('work_city_show')->default(0);
            $table->string('work_phone')->nullable();
            $table->text('description')->nullable();
            $table->string('audience')->nullable();
            $table->string('interests')->nullable();
            $table->text('hear_about')->nullable();
            $table->boolean('newsletter')->nullable();
            $table->boolean('notifications')->nullable();
            $table->boolean('conditions')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('notifs_check')->nullable();
            $table->integer('image_id')->default(1);
            $table->boolean('verified')->default(true);
            $table->boolean('ban')->default(false);
            $table->boolean('approved_email')->default(0);
            $table->boolean('refused_email')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
