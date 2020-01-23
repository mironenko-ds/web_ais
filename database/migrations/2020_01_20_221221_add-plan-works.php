<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanWorks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('departament_id');
            $table->unsignedBigInteger('work_id');
            $table->string('academic_year');
            $table->string('title');
            $table->text('description');
            $table->integer('norm_semester_1_plan');
            $table->integer('norm_semester_2_plan');
            $table->integer('count_plan');
            $table->integer('percentage_plan');
            $table->integer('norm_semester_1_fact');
            $table->integer('norm_semester_2_fact');
            $table->integer('count_fact');
            $table->integer('percentage_fact');
            $table->json('materials')->nullable();
            $table->boolean('status')->default(false);

            $table->softDeletesTz();
            $table->timestampsTz();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('departament_id')->references('id')->on('departments');
            $table->foreign('work_id')->references('id')->on('works');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_works');
    }
}
