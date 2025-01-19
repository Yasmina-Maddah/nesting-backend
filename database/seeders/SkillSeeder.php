<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $skills = [
            [
                'skill_name' => 'Puzzle and Solve',
                'description' => 'Discover how things work and solve problems through creative solutions.',
            ],
            [
                'skill_name' => 'Wonder and Learn',
                'description' => 'Explore imagination and turn ideas into something real through creative expression.',
            ],
            [
                'skill_name' => 'Create and Explore',
                'description' => 'Understand the world through curiosity, learning, and exploration.',
            ],
            [
                'skill_name' => 'Listen and Express',
                'description' => 'Improve communication skills through storytelling and listening.',
            ],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
