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
        Schema::create('vendor_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // Reference to vendor
            $table->string('language', 255); // Language column
            $table->unsignedBigInteger('category_id')->default(0); // Foreign key reference to menu_categories
            $table->text('name'); // Name column
            $table->text('description')->nullable(); // Nullable description
            $table->text('image')->nullable(); // Nullable image
            $table->decimal('price_half', 10, 2)->nullable(); // Price half as decimal
            $table->decimal('price_full', 10, 2)->nullable(); // Price full as decimal
            $table->integer('order')->default(0); // Order column
            $table->tinyInteger('status')->default(1)->comment('1->available, 2->not available'); // Status as tinyInteger
            $table->string('menu_type', 255)->nullable(); // Menu type column
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('menu_categories')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_menus');
    }
};
