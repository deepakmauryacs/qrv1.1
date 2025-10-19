<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('dining_order_items')) {
            Schema::create('dining_order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('dining_order_id')->constrained('dining_orders')->onDelete('cascade');
                $table->foreignId('vendor_menu_id')->nullable()->constrained('vendor_menus')->nullOnDelete();
                $table->string('item_name');
                $table->string('variant')->nullable();
                $table->unsignedInteger('quantity');
                $table->decimal('unit_price', 10, 2);
                $table->decimal('total_price', 10, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dining_order_items');
    }
};
