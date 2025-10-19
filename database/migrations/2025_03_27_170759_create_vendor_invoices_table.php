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
        Schema::create('vendor_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // Vendor ID
            $table->string('invoice_id')->nullable(); // invoice ID
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('message')->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('total_amount', 8, 2)->nullable();
            $table->enum('invoice_status', [1, 2])->comment('1->Invoice Created, 2->Invoice Printed')->default(1);
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
        Schema::dropIfExists('vendor_invoices');
    }
};
