<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenRequestUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_creation_requests', function (Blueprint $table) {
            $table->foreign('departament')->references('id')->on('departments');
            $table->foreign('degree')->references('id')->on('academic_degrees');
            $table->foreign('post')->references('id')->on('posts');
            $table->foreign('faculty')->references('id')->on('facultes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_creation_requests', function (Blueprint $table) {
            $table->dropForeign(['department']);
            $table->dropForeign(['degree']);
            $table->dropForeign(['post']);
            $table->dropForeign(['faculty']);
        });
    }
}
