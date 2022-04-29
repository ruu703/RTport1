<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->unsignedInteger('fee_low');
            $table->unsignedInteger('fee_high');
            $table->text('detail');
            $table->bigInteger('order_user_id')->unsigned();
            $table->foreign('order_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('received_user_id')->nullable()->unsigned();
            $table->foreign('received_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('close_flg')->default(0);
            $table->boolean('delete_flg')->default(0);
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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['order_user_id']);
            $table->dropForeign(['received_user_id']);
        });
        Schema::dropIfExists('projects');
    }
}
