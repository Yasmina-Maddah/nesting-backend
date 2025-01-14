<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AiVisualization;

class AiVisualizationSeeder extends Seeder
{
    public function run()
    {
        AiVisualization::create([
            'parent_id' => 2,
            'skill_id' => 1,
            'story_input' => 'John learns multiplication through puzzles.',
            'visualization' => null,
        ]);

        AiVisualization::create([
            'parent_id' => 3,
            'skill_id' => 3,
            'story_input' => 'Jane paints a masterpiece to enhance creativity.',
            'visualization' => null,
        ]);
    }
}
