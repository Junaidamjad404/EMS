<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
             ['name' => 'Concerts'],
             ['name' => 'Workshops'],
             ['name' => 'Conferences'],
            ['name' => 'Seminars'],
            ['name' => 'Meetups'],
            ['name' => 'Festivals'],
            // Add more categories as needed
        ]);
    }
}
