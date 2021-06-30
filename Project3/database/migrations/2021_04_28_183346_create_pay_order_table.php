<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_order', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('discount');
            $table->float('total_pay', 8, 2); 
            $table->float('cash_in', 8, 2);
            $table->float('cash_out', 8, 2);
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
        Schema::dropIfExists('pay_order');
    }
}
