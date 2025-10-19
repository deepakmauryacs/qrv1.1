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
        Schema::create('menu_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // Vendor ID
            $table->unsignedBigInteger('request_id')->nullable(); // Ticket ID
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            // $table->string('document')->nullable();
            $table->text('message');
            $table->enum('status', [1, 2, 3])->comment('1->Request Sent, 2->Request Updated, 3->Request Rejected')->default(1);
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
        Schema::dropIfExists('menu_requests');
    }
};
