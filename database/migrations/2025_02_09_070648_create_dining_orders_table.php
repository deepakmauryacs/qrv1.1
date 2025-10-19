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
        Schema::create('dining_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // Change from string to BIGINT
            $table->string('order_id',15);
            $table->string('contact_no', 15);
            $table->string('email')->nullable();
            $table->string('table_number');
            $table->date('order_date')->default(now());
            $table->time('order_time')->default(now());
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->enum('status', ['pending', 'accepted', 'preparing', 'served', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'partial'])->default('unpaid');
            $table->enum('payment_method', ['cash', 'card', 'upi', 'wallet', 'other'])->nullable();

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
        Schema::dropIfExists('dining_orders');
    }
};
