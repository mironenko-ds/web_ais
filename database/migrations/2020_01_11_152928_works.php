<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Works extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number_indicator');
            $table->string('indicator');
            $table->string('norm_desc');
            $table->string('norm');
            $table->string('description');
            $table->unsignedBigInteger('works_kinds_id');

            $table->softDeletesTz();
            $table->timestampsTz();

            $table->foreign('works_kinds_id')->references('id')->on('works_kinds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works_kinds');
    }
}
