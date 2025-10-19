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
        Schema::create('ticket_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id'); // Foreign key referencing tickets table
            $table->unsignedBigInteger('user_id'); // ID of the user sending the message (could be vendor or customer)
            $table->text('message'); // The chat message content
            $table->string('attachment')->nullable(); // For file paths if attachments are needed
            $table->boolean('is_vendor')->default(false); // Flag to identify if message is from vendor or customer
            $table->timestamp('sent_at')->useCurrent(); // When the message was sent
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_chats');
    }
};
