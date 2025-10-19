<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Assuming vendor_id is a foreign key, adjust as needed
            $table->unsignedBigInteger('vendor_id');
            
            // Store logo path; nullable if not required
            $table->string('store_logo')->nullable();
            
            $table->string('store_name');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            
            // Use text if addresses can be lengthy
            $table->text('store_address');
            
            // Latitude and longitude: adjust precision and scale as needed.
            $table->decimal('store_lat', 10, 7);
            $table->decimal('store_long', 10, 7);
            
            // Dine in: typically 1 or 2
            $table->tinyInteger('dine_in')->comment('1: Option One, 2: Option Two');
            
            $table->string('store_email');
            $table->string('store_contact', 50);
            
            $table->timestamps();
            
            // Optionally, add foreign key constraint for vendor_id if vendors table exists:
            // $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
