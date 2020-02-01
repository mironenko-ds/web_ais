<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Feedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('content');
            $table->unsignedBigInteger('type_user');
            $table->unsignedBigInteger('departament_id');
            $table->json('materials')->nullable();
            $table->string('status')->default('0');

            $table->softDeletesTz();
            $table->timestampsTz();

            $table->foreign('departament_id')->references('id')->on('departments');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_user')->references('id')->on('user_roles');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
