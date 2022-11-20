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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->reference('id')->on('customers');
            $table->string('ZIP_code')->nullable();
            $table->string('city_or_province');
            $table->string('district');
            $table->string('ward_or_commune');
            $table->string('specific_address');
            $table->enum('address_type', array('Home', 'Office'));
            $table->enum('default_address', array('Yes', 'No'));
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
        Schema::dropIfExists('customer_addresses');
    }
};
