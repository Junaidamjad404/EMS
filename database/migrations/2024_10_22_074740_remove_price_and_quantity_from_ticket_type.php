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
        Schema::table('ticket_types', function (Blueprint $table) {
             if (Schema::hasColumn('ticket_types', 'price')) {
                $table->dropColumn('price');
            }

            // Check and drop 'quantity' column if it exists
            if (Schema::hasColumn('ticket_types', 'quantity')) {
                $table->dropColumn('quantity');
            }
            $table->string('name')->unique()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_types', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->after('ticket_type_id'); // Ticket price
            $table->integer('quantity')->after('price')->default(0); // Number of tickets available for this type
            $table->dropUnique(['name']); // Drop the unique index
            $table->string('name')->change(); // Change it back if needed (optional
        });
    }
};
