<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for events
        $events = [
            [
                'title' => 'Tech Conference 2024',
                'description' => 'A conference about the latest advancements in technology.',
                'date' => '2024-06-15',
                'location' => 'New York, NY',
                'category_id' => 1,
            ],
            [
                'title' => 'Health and Wellness Expo',
                'description' => 'Explore the latest trends in health and wellness.',
                'date' => '2024-07-20',
                'location' => 'Los Angeles, CA',
                'category_id' => 2,
            ],
            [
                'title' => 'Annual Sports Day',
                'description' => 'A fun-filled day of sports and activities for everyone.',
                'date' => '2024-08-05',
                'location' => 'Chicago, IL',
                'category_id' => 3,
            ],
            [
                'title' => 'Financial Planning Workshop',
                'description' => 'Learn how to manage your finances effectively.',
                'date' => '2024-09-10',
                'location' => 'San Francisco, CA',
                'category_id' => 4,
            ],
            [
                'title' => 'Art and Craft Fair',
                'description' => 'Showcasing local artists and their crafts.',
                'date' => '2024-10-15',
                'location' => 'Austin, TX',
                'category_id' => 5,
            ],
        ];

        DB::table('events')->insert($events);
    }
}
