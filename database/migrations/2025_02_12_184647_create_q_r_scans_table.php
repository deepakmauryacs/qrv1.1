<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('q_r_scans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id'); // Reference to the restaurant
            $table->string('qr_code'); // QR Code identifier
            $table->string('user_ip'); // Store user IP address
            $table->timestamp('scanned_at')->default(now()); // Timestamp of scan
            $table->timestamps();

            // Foreign key constraint (assuming restaurants table exists)
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('q_r_scans');
    }
};

