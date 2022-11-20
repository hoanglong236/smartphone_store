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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id', false, true)->reference('id')->on('products');
            $table->string('product_option_name_1')->nullable();
            $table->string('product_option_value_1')->nullable();
            $table->string('product_option_name_2')->nullable();
            $table->string('product_option_value_2')->nullable();
            $table->string('product_option_name_3')->nullable();
            $table->string('product_option_value_3')->nullable();
            $table->string('SKU');
            $table->integer('quantity', false, true);
            $table->integer('price', false, true);
            $table->integer('discount_percent', false, true);
            $table->integer('warranty_period', false, true);
            $table->string('short_desc')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('product_details');
    }
};
