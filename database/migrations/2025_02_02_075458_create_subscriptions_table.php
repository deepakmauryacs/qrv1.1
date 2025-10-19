<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('plan_name');  // Name of the subscription plan (e.g., 'Free', 'Basic', 'Premium')
            $table->decimal('amount', 8, 2);  // Subscription amount (e.g., 49.00, 99.00)
            $table->enum('status', ['active', 'inactive'])->default('active');  // Status of the subscription
            $table->timestamps();  // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
