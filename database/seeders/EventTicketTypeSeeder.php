<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventTicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        $ticketTypes = TicketType::all();

        // Sync ticket types with events (you can adjust how you want to associate them)
        foreach ($events as $event) {
                // Ensure we do not attempt to attach more ticket types than are available
            $randomCount = min(2, $ticketTypes->count()); // Adjust the number to attach based on availability
            $randomTicketTypes = $ticketTypes->random($randomCount)->pluck('id')->toArray(); // Get the random IDs

            // Attach the random ticket types to the event with random quantity and price
            foreach ($randomTicketTypes as $ticketTypeId) {
                $quantity = rand(1, 100); // Random quantity between 1 and 100
                $price = rand(20, 200); // Random price between 20 and 200 (adjust as needed)

                $event->ticketTypes()->attach($ticketTypeId, [
                    'quantity' => $quantity,
                    'price' => $price
                ]);
            }
        }
    }
}
