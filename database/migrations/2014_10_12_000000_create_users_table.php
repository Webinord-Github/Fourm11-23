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
            $table->string('title')->nullable();
            $table->string('environment')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('years_xp')->nullable();
            $table->string('work_city')->nullable();
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
            $table->string('image')->nullable();
            $table->boolean('verified')->default(true);
            $table->boolean('ban')->default(false);
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
