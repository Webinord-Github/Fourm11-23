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
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->integer('reported_author_user_id');
            $table->integer('reported_user_user_id');
            $table->longtext('report');
            $table->integer('conversation_id');
            $table->integer('reply_id');
            $table->boolean('fixed');
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
    Schema::dropIfExists('signalements');
    }
};
