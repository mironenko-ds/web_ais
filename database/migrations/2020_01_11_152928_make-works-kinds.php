<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeWorksKinds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works_kinds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kind_name');
            $table->unsignedBigInteger('type_work_id');

            $table->softDeletesTz();
            $table->timestampsTz();

            $table->foreign('type_work_id')->references('id')->on('type-works');
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
