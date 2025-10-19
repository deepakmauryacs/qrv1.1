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
        Schema::create('vendors_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade'); // Foreign key referencing vendors table
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade'); // Foreign key referencing subscriptions table
            $table->integer('month'); // Duration in months
            $table->timestamp('start_date'); // Start date of subscription
            $table->timestamp('end_date'); // End date of subscription
            $table->enum('is_expired', ['1', '2'])->default('1')->comment('1->Not Expired, 2->Expired'); // Subscription expiration status
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
        Schema::dropIfExists('vendors_subscriptions');
    }
};
