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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // Vendor ID
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->text('message');
            $table->integer('rating')->default(5); // 1 to 5 rating
            $table->timestamp('submitted_at')->useCurrent(); // Timestamp
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
        Schema::dropIfExists('feedback');
    }
};
