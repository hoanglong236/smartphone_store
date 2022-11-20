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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_title');
            $table->string('coupon_code');
            $table->enum('coupon_type', array("Percent", "Dollar"))->default("Percent");
            $table->integer('coupon_percent_value', false, true)->default(0);
            $table->integer('coupon_dollar_value', false, true)->default(0);
            $table->integer('coupon_quantity', false, true)->nullable();
            $table->date('coupon_start_date')->nullable();
            $table->date('coupon_finish_date')->nullable();
            $table->enum('coupon_status', array("Expired", "Out of stock", "Stocking"))->default("Stocking");
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
        Schema::dropIfExists('coupons');
    }
};
