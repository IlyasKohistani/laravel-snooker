<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('bill_no');
            $table->float('gross_amount')->unsigned();
            $table->tinyInteger('service_charge_rate');
            $table->float('service_charge_amount');
            $table->tinyInteger('vat_charge_rate');
            $table->float('vat_charge_amount');
            $table->float('discount');
            $table->float('net_amount');
            $table->bigInteger('table_id')->nullable()->unsigned();
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('SET NULL');
            $table->tinyInteger('paid_status');
            $table->bigInteger('store_id')->nullable()->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('SET NULL');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->string('comment')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('total_minutes')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
