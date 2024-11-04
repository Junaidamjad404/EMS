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
        Schema::table('event_ticket_type', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->after('ticket_type_id'); // Ticket price
            $table->integer('quantity')->after('price')->default(0); // Number of tickets available for this type

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_ticket_type', function (Blueprint $table) {
            //
        });
    }
};
