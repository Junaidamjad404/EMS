<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve all events
        $events = Event::all();

        // Define the ticket types you want to create
        $ticketTypes = [
            [
                'name' => 'Early Bird',
                'benefits' => 'Discounted price for general access',
                
                
            ],
            [
                'name' => 'Group Package (5 People)',
                'benefits' => 'Reserved group seating, discounted price for group',
                
                
            ],
            [
                'name' => 'Student Ticket',
                'benefits' => 'Discounted entry for students with valid ID',
                
                
            ],
            [
                'name' => 'Family Pass (2 Adults + 2 Kids)',
                'benefits' => 'Reserved seating for family, special activities for kids',
                
                
            ],
            [
                'name' => 'Super VIP',
                'benefits' => 'Private lounge, meet and greet, complimentary food and drinks, premium merchandise',
                
                
            ],
            ['name'=>'General Admission',
            'benefits'=> '	Access to the general event area'
],[
'name'=>'VIP',	'benefits'=>'Access to VIP lounge, complimentary drinks, priority seating']
            // Add more ticket types as needed...
        ];

        foreach ($ticketTypes as $ticketTypeData) {
            // Create the ticket type
            $ticketType = TicketType::create($ticketTypeData);

        }
    }
}
