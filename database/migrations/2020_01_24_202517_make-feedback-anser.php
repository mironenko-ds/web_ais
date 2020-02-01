<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeFeedbackAnser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback-anser', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('feedback_id');
            $table->text('anser');
            $table->unsignedBigInteger('asked_user');
            $table->unsignedBigInteger('answered_user');
            $table->boolean('asked_user_read')->default(false);
            $table->json('materials')->nullable();

            $table->softDeletesTz();
            $table->timestampsTz();

            $table->foreign('feedback_id')->references('id')->on('feedback');
            $table->foreign('asked_user')->references('id')->on('users');
            $table->foreign('answered_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_anser');
    }
}
