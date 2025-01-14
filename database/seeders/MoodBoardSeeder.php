<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MoodBoard;

class MoodBoardSeeder extends Seeder
{
    public function run()
    {
        // Example mood board entries for Child Profile ID 1
        MoodBoard::create([
            'child_profile_id' => 1,
            'image_path' => 'images/moodboard/sunset.jpg',
            'description' => 'A beautiful sunset.',
        ]);

        MoodBoard::create([
            'child_profile_id' => 1,
            'image_path' => 'images/moodboard/beach.jpg',
            'description' => 'A relaxing beach.',
        ]);

        // Example mood board entries for Child Profile ID 2
        MoodBoard::create([
            'child_profile_id' => 2,
            'image_path' => 'images/moodboard/mountain.jpg',
            'description' => 'A scenic mountain view.',
        ]);

        MoodBoard::create([
            'child_profile_id' => 2,
            'image_path' => 'images/moodboard/forest.jpg',
            'description' => 'A calm and peaceful forest.',
        ]);
    }
}
