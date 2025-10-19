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
        Schema::table('dining_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('dining_orders', 'customer_name')) {
                $table->string('customer_name')->after('order_id');
            }

            if (!Schema::hasColumn('dining_orders', 'order_type')) {
                $table->enum('order_type', ['dine-in', 'pickup'])->default('dine-in')->after('customer_name');
            }

            if (!Schema::hasColumn('dining_orders', 'special_request')) {
                $table->text('special_request')->nullable()->after('payment_method');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dining_orders', function (Blueprint $table) {
            if (Schema::hasColumn('dining_orders', 'special_request')) {
                $table->dropColumn('special_request');
            }

            if (Schema::hasColumn('dining_orders', 'order_type')) {
                $table->dropColumn('order_type');
            }

            if (Schema::hasColumn('dining_orders', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
        });
    }
};
