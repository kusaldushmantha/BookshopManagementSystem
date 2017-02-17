<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAdminOrdersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adminorders', function (Blueprint $table) {
            $table->text('customername')->after('order_id');
            $table->text('address')->after('customername');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function($table)
        {

            $table->dropColumn('customername');
            $table->dropColumn('address');
        });
    }
}
