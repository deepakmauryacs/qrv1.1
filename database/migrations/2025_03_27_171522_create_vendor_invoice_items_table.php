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
        Schema::create('vendor_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable(); // invoice ID
            $table->integer('item_id');
            $table->string('item_name');
            $table->enum('type', [1, 2])->comment('1-> Half Price, 2-> Full Price')->default(1);
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('quantity', 8, 2)->nullable();
            $table->string('message')->nullable();
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
        Schema::dropIfExists('vendor_invoice_items');
    }
};
