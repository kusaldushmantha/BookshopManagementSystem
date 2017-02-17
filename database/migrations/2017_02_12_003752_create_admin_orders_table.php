<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAdminOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminorders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->string('order_status')->default('Ready');
            $table->timestamp('updated_at');
            $table->timestamp('created_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('adminorders');
    }
}
