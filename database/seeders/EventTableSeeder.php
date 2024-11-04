<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all categories and users
        $categories = Category::all();
        $users = User::all();

        // Define some sample locations
        $locations = [
            'New York, NY',
            'Los Angeles, CA',
            'Chicago, IL',
            'Houston, TX',
            'Phoenix, AZ',
            'Philadelphia, PA',
            'San Antonio, TX',
            'San Diego, CA',
            'Dallas, TX',
            'San Jose, CA',
        ];

        $statues=['approved','pending','completed','cancelled'];

        // Create 10 sample events
        for ($i = 1; $i <= 10; $i++) {
            Event::create([
                'title' => 'Sample Event ' . $i,
                'date' => now()->addDays(rand(1, 30)), // Random date in the next 30 days
                'description' => 'This is a description for Sample Event ' . $i,
                'category_id' => $categories->random()->id, // Random category
                'organizer_id' => $users->random()->id,         // Random user
                'location' => $locations[array_rand($locations)], // Random location from predefined array
                'status' => $statues[array_rand($statues)],
            ]);
        }
    }
}
