<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AiVisualization;
use App\Models\Skill;


class AiVisualizationSeeder extends Seeder
{
    public function run()
    {

        $MathSkillId = Skill::where('skill_name', 'Math')->value('id');
        $ReadingSkillId = Skill::where('skill_name', 'Reading')->value('id');
        $creativitySkillId = Skill::where('skill_name', 'Creativity')->value('id');

        // Example visualizations for Parent ID 1
        AiVisualization::create([
            'parent_id' => 1,
            'skill_id' => $MathSkillId,
            'theme' => 'Problem Solving',
            'prompt' => 'Tell a story about a child learning to solve puzzles.',
            'generated_story' => 'This is a simulated story about Critical Thinking and Problem Solving based on the prompt: Tell a story about a child learning to solve puzzles.',
        ]);

        AiVisualization::create([
            'parent_id' => 1,
            'skill_id' => $ReadingSkillId,
            'theme' => 'Collaboration',
            'prompt' => 'Create a story about kids working together to build a treehouse.',
            'generated_story' => 'This is a simulated story about Teamwork and Collaboration based on the prompt: Create a story about kids working together to build a treehouse.',
        ]);

        // Example visualizations for Parent ID 2
        AiVisualization::create([
            'parent_id' => 2,
            'skill_id' => $creativitySkillId,
            'theme' => 'Art and Design',
            'prompt' => 'Write a story about a young artist designing their first mural.',
            'generated_story' => 'This is a simulated story about Creativity and Art and Design based on the prompt: Write a story about a young artist designing their first mural.',
        ]);

    
    }
}
