<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPointAndHourWorks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('norm');
            $table->float('norm-point')->nullable();
            $table->float('norm-hour')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('norm-point');
            $table->dropColumn('norm-hour');
        });
    }
}
