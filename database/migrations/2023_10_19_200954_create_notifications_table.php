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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('sujet');
            $table->string('type');
            $table->integer('conversation_id')->nullable();
            $table->string('reply_author_id')->nullable();
            $table->integer('reply_id')->nullable();
            $table->integer('tool_id')->nullable();
            $table->integer('post_id')->nullable();
            $table->string('notif_link')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
