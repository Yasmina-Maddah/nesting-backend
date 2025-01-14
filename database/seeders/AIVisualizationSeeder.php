<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AIVisualization;

class AIVisualizationSeeder extends Seeder
{
    public function run()
    {
        AIVisualization::create([
            'parent_id' => 2,
            'skill_id' => 1,
            'story_input' => 'John learns multiplication through puzzles.',
            'visualization' => null,
        ]);

        AIVisualization::create([
            'parent_id' => 3,
            'skill_id' => 3,
            'story_input' => 'Jane paints a masterpiece to enhance creativity.',
            'visualization' => null,
        ]);
    }
}
