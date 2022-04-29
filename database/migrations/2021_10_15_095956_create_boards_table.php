<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->bigInteger('order_user_id')->unsigned();
            $table->foreign('order_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('apply_user_id')->unsigned();
            $table->foreign('apply_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('boards', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['order_user_id']);
            $table->dropForeign(['apply_user_id']);
        });
        Schema::dropIfExists('boards');
    }
}
