<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $count = "CREATE VIEW order_show AS Select 
        t2.product_id,
        t2.pay_order_id,
        t2.name,
        t2.price,
        t2.qty,
        t3.discount,
        t3.total_pay,
        t3.cash_in,
        t3.cash_out,
        t2.datetime
        from project3.order t2 inner join pay_order t3 On t2.pay_order_id = t3.id;";
        DB::statement($count);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("if have order_show please exite");
    }
}
