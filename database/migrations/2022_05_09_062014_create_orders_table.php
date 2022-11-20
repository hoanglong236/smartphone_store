<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->integer('customer_id', false, true)->reference('id')->on('customers');
            $table->string('customer_phone');
            $table->string('delivery_address');
            $table->float('total');
            $table->string('payment_method');
            $table->enum('payment_status', array('Unpaid' ,'Paid'))->default('Unpaid');
            $table->enum('status', array('Received', 'Processed', 'Packed', 'Delivery', 'Completed', 'Cancelled'))->default('Received');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
};
