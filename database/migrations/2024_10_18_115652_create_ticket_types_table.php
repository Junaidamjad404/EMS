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
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade'); // Links to Event
            $table->string('name'); // e.g., General Admission, VIP
            $table->decimal('price', 8, 2); // Ticket price
            $table->text('benefits')->nullable(); // Benefits for the ticket type
            $table->integer('quantity')->default(0); // Number of tickets available for this type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};
