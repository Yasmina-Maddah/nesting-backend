<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AIVisualization;

class AIVisualizationSeeder extends Seeder
{
    public function run()
    {
        // Example visualizations for Parent ID 1
        AIVisualization::create([
            'parent_id' => 1,
            'skill' => 'Critical Thinking',
            'theme' => 'Problem Solving',
            'prompt' => 'Tell a story about a child learning to solve puzzles.',
            'generated_story' => 'This is a simulated story about Critical Thinking and Problem Solving based on the prompt: Tell a story about a child learning to solve puzzles.',
        ]);

        AIVisualization::create([
            'parent_id' => 1,
            'skill' => 'Teamwork',
            'theme' => 'Collaboration',
            'prompt' => 'Create a story about kids working together to build a treehouse.',
            'generated_story' => 'This is a simulated story about Teamwork and Collaboration based on the prompt: Create a story about kids working together to build a treehouse.',
        ]);

        // Example visualizations for Parent ID 2
        AIVisualization::create([
            'parent_id' => 2,
            'skill' => 'Creativity',
            'theme' => 'Art and Design',
            'prompt' => 'Write a story about a young artist designing their first mural.',
            'generated_story' => 'This is a simulated story about Creativity and Art and Design based on the prompt: Write a story about a young artist designing their first mural.',
        ]);

        AIVisualization::create([
            'parent_id' => 2,
            'skill' => 'Resilience',
            'theme' => 'Overcoming Challenges',
            'prompt' => 'Share a story about a child learning to ride a bike after falling multiple times.',
            'generated_story' => 'This is a simulated story about Resilience and Overcoming Challenges based on the prompt: Share a story about a child learning to ride a bike after falling multiple times.',
        ]);
    }
}
